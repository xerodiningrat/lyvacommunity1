<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class DiscordCommunityStats
{
    /**
     * @return array{
     *     active_members: int|null,
     *     total_members: int|null,
     *     events_count: int,
     *     years_active: int|null,
     *     founded_year: int|null,
     *     invite_url: string,
     *     server_name: string|null
     * }
     */
    public function get(): array
    {
        $inviteUrl = (string) config('services.discord.invite_url', '');
        $cacheKey = 'discord.community.stats.v3';
        $cacheTtlSeconds = (int) config('services.discord.cache_ttl_seconds', 300);

        $stats = Cache::remember($cacheKey, now()->addSeconds($cacheTtlSeconds), function () use ($inviteUrl): array {
            return $this->fetch($inviteUrl);
        });

        return array_replace($this->fallback($inviteUrl), $stats);
    }

    /**
     * @return array{
     *     active_members: int|null,
     *     total_members: int|null,
     *     events_count: int,
     *     years_active: int|null,
     *     founded_year: int|null,
     *     invite_url: string,
     *     server_name: string|null
     * }
     */
    protected function fetch(string $inviteUrl): array
    {
        $inviteCode = $this->extractInviteCode($inviteUrl);

        if ($inviteCode === null) {
            return $this->fallback($inviteUrl);
        }

        try {
            $response = Http::baseUrl('https://discord.com/api/v10')
                ->acceptJson()
                ->connectTimeout(5)
                ->timeout(10)
                ->retry([200, 500], throw: false)
                ->get("/invites/{$inviteCode}", [
                    'with_counts' => 'true',
                ]);

            if (! $response->successful()) {
                return $this->fallback($inviteUrl);
            }

            $activeMembers = data_get($response->json(), 'approximate_presence_count');
            $totalMembers = data_get($response->json(), 'approximate_member_count');
            $guildId = data_get($response->json(), 'guild.id');
            $guildCreatedAt = $this->guildCreatedAt($guildId);

            return [
                'active_members' => is_numeric($activeMembers) ? (int) $activeMembers : null,
                'total_members' => is_numeric($totalMembers) ? (int) $totalMembers : null,
                'events_count' => 0,
                'years_active' => $this->yearsActive($guildCreatedAt),
                'founded_year' => $guildCreatedAt?->year,
                'invite_url' => $inviteUrl,
                'server_name' => data_get($response->json(), 'guild.name'),
            ];
        } catch (Throwable) {
            return $this->fallback($inviteUrl);
        }
    }

    protected function extractInviteCode(string $inviteUrl): ?string
    {
        if ($inviteUrl === '') {
            return null;
        }

        $path = trim((string) parse_url($inviteUrl, PHP_URL_PATH), '/');

        if ($path === '') {
            return null;
        }

        if (Str::contains($inviteUrl, ['discord.gg/', 'discord.com/invite/'])) {
            return Str::afterLast($path, '/');
        }

        return $path;
    }

    /**
     * @return array{
     *     active_members: int|null,
     *     total_members: int|null,
     *     events_count: int,
     *     years_active: int|null,
     *     founded_year: int|null,
     *     invite_url: string,
     *     server_name: string|null
     * }
     */
    protected function fallback(string $inviteUrl): array
    {
        return [
            'active_members' => null,
            'total_members' => null,
            'events_count' => 0,
            'years_active' => null,
            'founded_year' => null,
            'invite_url' => $inviteUrl,
            'server_name' => null,
        ];
    }

    protected function guildCreatedAt(mixed $guildId): ?CarbonImmutable
    {
        if (! is_numeric($guildId)) {
            return null;
        }

        $timestampMilliseconds = ((int) $guildId >> 22) + 1420070400000;

        return CarbonImmutable::createFromTimestampMs($timestampMilliseconds);
    }

    protected function yearsActive(?CarbonImmutable $guildCreatedAt): ?int
    {
        if ($guildCreatedAt === null) {
            return null;
        }

        return max(1, now()->year - $guildCreatedAt->year);
    }
}
