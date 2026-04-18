<?php

use App\Models\CommunityEvent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

test('the events page loads active events from the backend', function () {
    fakeDiscordForEventsPage();

    CommunityEvent::factory()->create([
        'name' => 'Alpha Tournament',
        'slug' => 'alpha-tournament',
        'event_date' => '2026-04-25',
        'sort_order' => 20,
        'status' => 'soon',
        'status_label' => '⏳ Soon',
        'status_class' => 'evs',
    ]);

    CommunityEvent::factory()->create([
        'name' => 'Beta Sprint',
        'slug' => 'beta-sprint',
        'event_date' => '2026-04-18',
        'sort_order' => 10,
        'status' => 'live',
        'status_label' => '🔴 Live',
        'status_class' => 'evl',
    ]);

    CommunityEvent::factory()->inactive()->create([
        'name' => 'Hidden Event',
        'slug' => 'hidden-event',
        'event_date' => '2026-04-10',
    ]);

    $response = $this->get('/events');

    $response
        ->assertSuccessful()
        ->assertSeeText('Beta Sprint')
        ->assertSeeText('Alpha Tournament')
        ->assertDontSeeText('Hidden Event');

    expect(strpos($response->getContent(), 'Beta Sprint'))
        ->toBeLessThan(strpos($response->getContent(), 'Alpha Tournament'));
});

function fakeDiscordForEventsPage(): void
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
