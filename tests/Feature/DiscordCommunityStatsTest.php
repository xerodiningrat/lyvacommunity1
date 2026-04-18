<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

test('the welcome page falls back when discord stats are unavailable', function () {
    Config::set('services.discord.invite_url', 'https://discord.gg/test-community');
    Config::set('services.discord.bot_token', 'test-bot-token');
    Config::set('services.discord.gallery_channel_id', 'test-gallery-channel');

    Http::fake([
        'https://discord.com/api/v10/invites/test-community*' => Http::response([], 500),
        'https://discord.com/api/v10/channels/test-gallery-channel/messages*' => Http::response([], 500),
    ]);

    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSeeText('Komunitas Discord LYVA')
        ->assertSeeText('0')
        ->assertSeeText('Gallery Discord belum ada gambar')
        ->assertDontSeeText('Games');
});
