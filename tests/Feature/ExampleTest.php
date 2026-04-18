<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

test('the application returns a successful response', function () {
    fakeDiscordForPages();

    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSeeText('595 Member Aktif')
        ->assertSeeText('1,053+')
        ->assertSeeText('Events')
        ->assertSeeText('1')
        ->assertSeeText('Lyva Gallery')
        ->assertSeeText('Fei')
        ->assertDontSeeText('Games');

    $this->assertDatabaseHas('discord_gallery_media', [
        'discord_attachment_id' => 'attachment-1',
        'media_type' => 'image',
    ]);
});

test('the navbar pages have dedicated routes', function (string $uri, string $expectedText) {
    fakeDiscordForPages();

    $this->get($uri)
        ->assertSuccessful()
        ->assertSeeText($expectedText);
})->with([
    ['/dashboard', 'Dashboard'],
    ['/gallery', 'Momen Terbaik LYVA'],
    ['/shop', 'Item Eksklusif'],
    ['/members', 'Owner, Admin, dan Staff LYVA'],
    ['/events', 'Agenda LYVA'],
    ['/leaderboard', 'Top Players LYVA'],
]);

test('the members page only shows leadership roles from discord', function () {
    fakeDiscordForPages();

    $this->get('/members')
        ->assertSuccessful()
        ->assertSeeText('Fenzane')
        ->assertSeeText('GHASIMA')
        ->assertSeeText('RATU')
        ->assertSeeText('MOZY')
        ->assertSeeText('PT ARCEVA INDONESIA GROUP')
        ->assertSee('https://cdn.discordapp.com/avatars/user-1/avatar-fenzane.png?size=128', false)
        ->assertSee('https://cdn.discordapp.com/avatars/user-4/avatar-mozy.png?size=128', false)
        ->assertDontSeeText('chiroo')
        ->assertDontSeeText('BOT')
        ->assertDontSeeText('Member Unggulan')
        ->assertDontSeeText('RoboUser')
        ->assertDontSeeText('LYVA STUDIO');
});

function fakeDiscordForPages(): void
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
        'https://discord.com/api/v10/channels/test-gallery-channel/messages*' => Http::response([
            [
                'id' => 'message-1',
                'timestamp' => '2026-04-18T00:00:00+00:00',
                'author' => [
                    'username' => 'fei',
                    'global_name' => 'Fei',
                ],
                'attachments' => [
                    [
                        'id' => 'attachment-1',
                        'filename' => 'lyva-gallery.png',
                        'url' => 'https://cdn.discordapp.com/test-image.png',
                        'width' => 1440,
                        'height' => 837,
                        'content_type' => 'image/png',
                    ],
                    [
                        'id' => 'attachment-2',
                        'filename' => 'lyva-clip.mp4',
                        'url' => 'https://cdn.discordapp.com/test-video.mp4',
                        'width' => 1440,
                        'height' => 837,
                        'content_type' => 'video/mp4',
                    ],
                ],
            ],
        ]),
        'https://discord.com/api/v10/guilds/1425164983691382859/roles' => Http::response([
            [
                'id' => '1425164984056549459',
                'name' => 'Founder',
            ],
            [
                'id' => '1454766615743954955',
                'name' => 'Co-Owner',
            ],
            [
                'id' => '1455302998283784483',
                'name' => 'Community Manager',
            ],
            [
                'id' => '1454086035805049044',
                'name' => 'Community Leader',
            ],
            [
                'id' => '1453569126902665226',
                'name' => 'Community Queen',
            ],
            [
                'id' => '1454773302273904711',
                'name' => 'LYVA Team',
            ],
            [
                'id' => '1425164984056549458',
                'name' => 'Lead Moderator',
            ],
            [
                'id' => '1455303746039971933',
                'name' => 'Developer',
            ],
            [
                'id' => '1425164983691382862',
                'name' => 'BOT',
            ],
            [
                'id' => '1425164983691382863',
                'name' => 'Member',
            ],
        ]),
        'https://discord.com/api/v10/guilds/1425164983691382859/roles/member-counts' => Http::response([
            '1425164984056549459' => 3,
            '1454766615743954955' => 1,
            '1455302998283784483' => 2,
            '1454086035805049044' => 1,
            '1453569126902665226' => 2,
            '1454773302273904711' => 2,
            '1425164984056549458' => 6,
            '1455303746039971933' => 1,
            '1425164983691382862' => 26,
            '1425164983691382863' => 1009,
        ]),
        'https://discord.com/api/v10/guilds/1425164983691382859/members/search*' => Http::response([
            [
                'nick' => 'Fenzane',
                'roles' => ['1425164984056549459', '1425164983691382863'],
                'user' => [
                    'id' => 'user-1',
                    'username' => 'febyanta',
                    'avatar' => 'avatar-fenzane',
                ],
            ],
            [
                'nick' => 'GHASIMA',
                'roles' => ['1425164984056549459'],
                'user' => [
                    'id' => 'user-2',
                    'username' => 'fenzane',
                    'avatar' => 'avatar-ghasima',
                ],
            ],
            [
                'nick' => 'RATU',
                'roles' => ['1455302998283784483'],
                'user' => [
                    'id' => 'user-3',
                    'username' => 'indigoent_',
                    'avatar' => 'avatar-ratu',
                ],
            ],
            [
                'nick' => 'MOZY',
                'roles' => ['1454766615743954955', '1454086035805049044', '1455303746039971933'],
                'user' => [
                    'id' => 'user-4',
                    'username' => 'mozytcn',
                    'avatar' => 'avatar-mozy',
                ],
            ],
            [
                'nick' => 'PT ARCEVA INDONESIA GROUP',
                'roles' => ['1454773302273904711', '1425164983691382863'],
                'user' => [
                    'id' => 'user-5',
                    'username' => 'ptarcevaindonesiagroup',
                    'avatar' => 'avatar-arceva',
                ],
            ],
            [
                'nick' => 'LYVA STUDIO',
                'roles' => ['1425164984056549459', '1425164983691382862'],
                'user' => [
                    'id' => 'bot-1',
                    'username' => 'LYVA STUDIO',
                    'bot' => true,
                ],
            ],
            [
                'nick' => 'chiroo',
                'roles' => ['1425164984056549458'],
                'user' => [
                    'id' => '1414976447659118595',
                    'username' => 'chiroo0997_51577',
                    'avatar' => 'avatar-chiro',
                ],
            ],
        ]),
        'https://discord.com/api/v10/guilds/1425164983691382859/members*' => Http::response([
            'message' => 'Missing Access',
            'code' => 50001,
        ], 403),
    ]);
}
