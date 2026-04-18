<?php

use App\Models\ChatMessage;
use App\Services\DiscordAuthService;
use Illuminate\Http\Request;

test('chat page redirects guest users to discord login', function () {
    $this->get(route('chat'))
        ->assertRedirect(route('auth.discord.redirect'));
});

test('chat page can be opened by discord members', function () {
    ChatMessage::query()->create([
        'discord_user_id' => 'member-1',
        'display_name' => 'LyvaKing',
        'username' => 'lyvaking',
        'avatar_url' => null,
        'message' => 'Halo semua member LYVA!',
    ]);

    $this->withSession(discordMemberSession())
        ->get(route('chat'))
        ->assertOk()
        ->assertSeeText('LYVA Chat')
        ->assertSeeText('Halo semua member LYVA!')
        ->assertSeeText('LyvaKing');
});

test('discord members can send chat messages', function () {
    $this->withSession(discordMemberSession())
        ->post(route('chat.store'), [
            'message' => 'Selamat malam semuanya!',
        ])
        ->assertRedirect(route('chat'));

    $this->assertDatabaseHas('chat_messages', [
        'discord_user_id' => 'discord-member-1',
        'display_name' => 'Lyva Member',
        'message' => 'Selamat malam semuanya!',
    ]);
});

test('discord remember cookie restores login payload', function () {
    $request = Request::create('/chat', 'GET', [], [
        DiscordAuthService::REMEMBER_COOKIE => json_encode(discordMemberPayload(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
    ]);

    $session = app('session')->driver();
    $session->start();
    $request->setLaravelSession($session);

    $restored = app(DiscordAuthService::class)->restoreRememberedUser($request);

    expect($restored)
        ->toBeArray()
        ->and($restored['id'])->toBe('discord-member-1')
        ->and($request->session()->get(DiscordAuthService::SESSION_KEY)['username'])->toBe('lyvamember');
});

function discordMemberSession(): array
{
    return [
        DiscordAuthService::SESSION_KEY => discordMemberPayload(),
    ];
}

function discordMemberPayload(): array
{
    return [
        'id' => 'discord-member-1',
        'name' => 'Lyva Member',
        'username' => 'lyvamember',
        'avatar_url' => null,
        'is_core_member' => false,
        'primary_role' => null,
        'redirect_to' => route('home'),
    ];
}
