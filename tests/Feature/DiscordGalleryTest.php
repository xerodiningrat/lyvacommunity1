<?php

use App\Models\DiscordGalleryMedia;
use App\Services\DiscordGallery;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

test('discord gallery media is synced into the local database', function () {
    Config::set('services.discord.bot_token', 'test-bot-token');
    Config::set('services.discord.gallery_channel_id', 'test-gallery-channel');
    Config::set('services.discord.cache_ttl_seconds', 300);

    Http::fake([
        'https://discord.com/api/v10/channels/test-gallery-channel/messages*' => Http::response([
            [
                'id' => 'message-2',
                'timestamp' => '2026-04-17T15:32:59.330000+00:00',
                'author' => [
                    'username' => 'lyva-admin',
                    'global_name' => 'Lyva Admin',
                ],
                'attachments' => [
                    [
                        'id' => 'attachment-video-1',
                        'filename' => 'weekly-highlight.mp4',
                        'content_type' => 'video/mp4',
                        'url' => 'https://cdn.discordapp.com/videos/weekly-highlight.mp4',
                    ],
                ],
            ],
            [
                'id' => 'message-1',
                'timestamp' => '2026-04-16T10:15:00.000000+00:00',
                'author' => [
                    'username' => 'fei',
                    'global_name' => 'fei',
                ],
                'attachments' => [
                    [
                        'id' => 'attachment-image-1',
                        'filename' => 'mega-battle.png',
                        'content_type' => 'image/png',
                        'url' => 'https://cdn.discordapp.com/images/mega-battle.png',
                        'width' => 1440,
                        'height' => 837,
                    ],
                ],
            ],
        ], 200),
    ]);

    $count = app(DiscordGallery::class)->sync(true);

    expect($count)->toBe(2);
    expect(DiscordGalleryMedia::query()->count())->toBe(2);

    $storedImage = DiscordGalleryMedia::query()
        ->where('discord_attachment_id', 'attachment-image-1')
        ->firstOrFail();

    expect($storedImage->posted_at?->toDateTimeString())->toBe('2026-04-16 10:15:00');
    expect($storedImage->media_type)->toBe('image');

    $gallery = app(DiscordGallery::class)->get();

    expect($gallery)->toHaveCount(2);
    expect($gallery[0]['id'])->toBe('attachment-video-1');
    expect($gallery[0]['media_type'])->toBe('video');
});

test('discord gallery can be paginated to reduce page weight', function () {
    Config::set('services.discord.bot_token', '');
    Config::set('services.discord.gallery_channel_id', '');

    collect(range(1, 15))->each(function (int $index): void {
        DiscordGalleryMedia::query()->create([
            'discord_attachment_id' => 'gallery-'.$index,
            'source_message_id' => 'message-'.$index,
            'source_channel_id' => 'channel-1',
            'title' => 'Gallery '.$index,
            'media_url' => 'https://cdn.discordapp.com/media-'.$index.'.png',
            'media_type' => 'image',
            'mime_type' => 'image/png',
            'author_name' => 'LYVA Member',
            'posted_at' => now()->subMinutes($index),
        ]);
    });

    $paginator = app(DiscordGallery::class)->paginate(12);

    expect($paginator->perPage())->toBe(12);
    expect($paginator->count())->toBe(12);
    expect($paginator->total())->toBe(15);
    expect($paginator->hasMorePages())->toBeTrue();
});
