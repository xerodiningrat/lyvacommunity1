<?php

use App\Models\LeaderboardEntry;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

test('the leaderboard page loads active entries from the backend', function () {
    fakeDiscordForLeaderboardPage();

    LeaderboardEntry::factory()->create([
        'player_name' => 'Alpha King',
        'player_slug' => 'alpha-king',
        'points' => 90000,
        'wins' => 30,
        'events_joined' => 60,
    ]);

    LeaderboardEntry::factory()->create([
        'player_name' => 'Beta Mage',
        'player_slug' => 'beta-mage',
        'points' => 65000,
        'wins' => 21,
        'events_joined' => 48,
    ]);

    LeaderboardEntry::factory()->inactive()->create([
        'player_name' => 'Hidden Rank',
        'player_slug' => 'hidden-rank',
        'points' => 99000,
    ]);

    $response = $this->get('/leaderboard');

    $response
        ->assertSuccessful()
        ->assertSeeText('Alpha King')
        ->assertSeeText('Beta Mage')
        ->assertDontSeeText('Hidden Rank');

    expect(strpos($response->getContent(), 'Alpha King'))
        ->toBeLessThan(strpos($response->getContent(), 'Beta Mage'));
});

function fakeDiscordForLeaderboardPage(): void
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
