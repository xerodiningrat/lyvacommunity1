<?php

namespace App\Services;

use App\Models\DiscordGalleryMedia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class DiscordGallery
{
    /**
     * @return array<int, array{
     *     id: string,
     *     title: string,
     *     media_url: string,
     *     media_type: string,
     *     width: int|null,
     *     height: int|null,
     *     author: string,
     *     posted_at: string
     * }>
     */
    public function get(?int $limit = null): array
    {
        $this->syncIfNeeded();

        $query = DiscordGalleryMedia::query()
            ->orderByDesc('posted_at')
            ->orderByDesc('id');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get()
            ->map(fn (DiscordGalleryMedia $media): array => [
                'id' => $media->discord_attachment_id,
                'title' => $media->title,
                'media_url' => $media->media_url,
                'media_type' => $media->media_type,
                'width' => $media->width,
                'height' => $media->height,
                'author' => $media->author_name ?? 'LYVA Member',
                'posted_at' => $media->posted_at?->toIso8601String() ?? now()->toIso8601String(),
            ])
            ->all();
    }

    public function paginate(int $perPage = 12): LengthAwarePaginator
    {
        $this->syncIfNeeded();

        return DiscordGalleryMedia::query()
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->through(fn (DiscordGalleryMedia $media): array => [
                'id' => $media->discord_attachment_id,
                'title' => $media->title,
                'media_url' => $media->media_url,
                'media_type' => $media->media_type,
                'width' => $media->width,
                'height' => $media->height,
                'author' => $media->author_name ?? 'LYVA Member',
                'posted_at' => $media->posted_at?->toIso8601String() ?? now()->toIso8601String(),
            ]);
    }

    public function sync(bool $force = false): int
    {
        $token = (string) config('services.discord.bot_token', '');
        $channelId = (string) config('services.discord.gallery_channel_id', '');

        if ($token === '' || $channelId === '') {
            return 0;
        }

        if (! $force && ! $this->shouldSync()) {
            return DiscordGalleryMedia::query()->count();
        }

        return Cache::lock('discord.gallery.sync.lock', 30)->get(function () use ($token, $channelId, $force): int {
            if (! $force && ! $this->shouldSync()) {
                return DiscordGalleryMedia::query()->count();
            }

            return $this->syncFromDiscord($token, $channelId);
        }) ?? DiscordGalleryMedia::query()->count();
    }

    protected function syncIfNeeded(): void
    {
        $this->sync();
    }

    protected function shouldSync(): bool
    {
        return ! Cache::has($this->syncCacheKey()) || DiscordGalleryMedia::query()->doesntExist();
    }

    protected function syncFromDiscord(string $token, string $channelId): int
    {
        try {
            $messages = $this->fetchMessages($token, $channelId);
            $mediaItems = $this->normalizeMediaItems(
                $this->mapMessagesToMedia($messages, $channelId),
            );

            if ($mediaItems->isEmpty()) {
                Cache::put($this->syncCacheKey(), now()->timestamp, now()->addSeconds($this->cacheTtlSeconds()));

                return DiscordGalleryMedia::query()->count();
            }

            DiscordGalleryMedia::query()->upsert(
                $mediaItems->all(),
                ['discord_attachment_id'],
                ['source_message_id', 'source_channel_id', 'title', 'media_url', 'media_type', 'mime_type', 'width', 'height', 'author_name', 'posted_at', 'updated_at'],
            );

            DiscordGalleryMedia::query()
                ->where('source_channel_id', $channelId)
                ->whereNotIn('discord_attachment_id', $mediaItems->pluck('discord_attachment_id'))
                ->delete();

            Cache::put($this->syncCacheKey(), now()->timestamp, now()->addSeconds($this->cacheTtlSeconds()));

            return DiscordGalleryMedia::query()->count();
        } catch (Throwable $exception) {
            Log::warning('Failed to sync Discord gallery media.', [
                'channel_id' => $channelId,
                'message' => $exception->getMessage(),
            ]);

            return DiscordGalleryMedia::query()->count();
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function fetchMessages(string $token, string $channelId): array
    {
        $messages = [];
        $before = null;

        do {
            $response = Http::baseUrl('https://discord.com/api/v10')
                ->acceptJson()
                ->withHeaders([
                    'Authorization' => "Bot {$token}",
                ])
                ->connectTimeout(5)
                ->timeout(10)
                ->retry([200, 500], throw: false)
                ->get("/channels/{$channelId}/messages", array_filter([
                    'limit' => 100,
                    'before' => $before,
                ]));

            if (! $response->successful()) {
                break;
            }

            $batch = $response->json();

            if (! is_array($batch) || $batch === []) {
                break;
            }

            $messages = [...$messages, ...$batch];
            $before = (string) data_get(last($batch), 'id', '');
        } while (count($batch) === 100 && $before !== '');

        return $messages;
    }

    /**
     * @param  array<int, array<string, mixed>>  $messages
     * @return Collection<int, array<string, mixed>>
     */
    protected function mapMessagesToMedia(array $messages, string $channelId): Collection
    {
        return collect($messages)
            ->flatMap(function (array $message) use ($channelId): array {
                return collect(data_get($message, 'attachments', []))
                    ->filter(function (array $attachment): bool {
                        $contentType = (string) data_get($attachment, 'content_type', '');

                        return Str::startsWith($contentType, ['image/', 'video/']);
                    })
                    ->map(fn (array $attachment): array => [
                        'discord_attachment_id' => (string) data_get($attachment, 'id', data_get($message, 'id')),
                        'source_message_id' => (string) data_get($message, 'id', ''),
                        'source_channel_id' => $channelId,
                        'title' => $this->titleFromFilename((string) data_get($attachment, 'filename', 'Gallery Media')),
                        'media_url' => (string) data_get($attachment, 'url', ''),
                        'media_type' => $this->mediaType((string) data_get($attachment, 'content_type', '')),
                        'mime_type' => data_get($attachment, 'content_type'),
                        'width' => is_numeric(data_get($attachment, 'width')) ? (int) data_get($attachment, 'width') : null,
                        'height' => is_numeric(data_get($attachment, 'height')) ? (int) data_get($attachment, 'height') : null,
                        'author_name' => (string) data_get($message, 'author.global_name', data_get($message, 'author.username', 'LYVA Member')),
                        'posted_at' => data_get($message, 'timestamp'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
                    ->all();
            })
            ->filter(fn (array $item): bool => $item['media_url'] !== '')
            ->values();
    }

    /**
     * @param  Collection<int, array<string, mixed>>  $mediaItems
     * @return Collection<int, array<string, mixed>>
     */
    protected function normalizeMediaItems(Collection $mediaItems): Collection
    {
        return $mediaItems
            ->map(function (array $item): array {
                $item['posted_at'] = filled($item['posted_at'])
                    ? Carbon::parse((string) $item['posted_at'])->toDateTimeString()
                    : null;
                $item['created_at'] = now()->toDateTimeString();
                $item['updated_at'] = now()->toDateTimeString();

                return $item;
            })
            ->values();
    }

    protected function mediaType(string $contentType): string
    {
        if (Str::startsWith($contentType, 'video/')) {
            return 'video';
        }

        return 'image';
    }

    protected function titleFromFilename(string $filename): string
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);

        return Str::of($name)
            ->replace(['_', '-'], ' ')
            ->squish()
            ->limit(42, '')
            ->title()
            ->value();
    }

    protected function syncCacheKey(): string
    {
        $channelId = (string) config('services.discord.gallery_channel_id', 'default');

        return "discord.gallery.synced_at.{$channelId}";
    }

    protected function cacheTtlSeconds(): int
    {
        return (int) config('services.discord.cache_ttl_seconds', 300);
    }
}
