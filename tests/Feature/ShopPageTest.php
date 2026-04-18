<?php

use App\Models\ShopItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

test('the shop page loads active items from the backend', function () {
    fakeDiscordForShopPage();

    ShopItem::factory()->create([
        'name' => 'Alpha Blade',
        'slug' => 'alpha-blade',
        'price' => 450,
        'currency' => 'Robux',
        'sort_order' => 20,
        'stars' => 5,
    ]);

    ShopItem::factory()->create([
        'name' => 'Zen Crown',
        'slug' => 'zen-crown',
        'price' => 999,
        'currency' => 'Robux',
        'sort_order' => 10,
        'stars' => 4,
    ]);

    ShopItem::factory()->inactive()->create([
        'name' => 'Hidden Item',
        'slug' => 'hidden-item',
        'sort_order' => 5,
    ]);

    $response = $this->get('/shop');

    $response
        ->assertSuccessful()
        ->assertSeeText('Zen Crown')
        ->assertSeeText('Alpha Blade')
        ->assertDontSeeText('Hidden Item');

    expect(strpos($response->getContent(), 'Zen Crown'))
        ->toBeLessThan(strpos($response->getContent(), 'Alpha Blade'));
});

function fakeDiscordForShopPage(): void
{
    Cache::forget('discord.leadership.directory.v4');
    Config::set('services.discord.invite_url', 'https://discord.gg/test-community');
    Config::set('services.discord.bot_token', 'test-bot-token');
    Config::set('services.discord.gallery_channel_id', 'test-gallery-channel');

    Http::fake([
        'https://discord.com/api/v10/invites/test-community*' => Http::response([
            'approximate_member_count' => 1053,
            'approximate_presence_count' => 595,
            'guild' => [
                'id' => '1425164983691382859',
                'name' => 'LYVA Community',
            ],
        ]),
        'https://discord.com/api/v10/channels/test-gallery-channel/messages*' => Http::response([], 200),
    ]);
}
