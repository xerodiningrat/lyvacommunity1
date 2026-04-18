<?php

use App\Services\DiscordAuthService;

test('discord members can subscribe chat push notifications', function () {
    config()->set('services.webpush.public_key', 'test-public-key');
    config()->set('services.webpush.private_key', 'test-private-key');
    config()->set('services.webpush.subject', 'https://lyvacommunity.test');

    $this->withSession(discordMemberSessionForPush())
        ->postJson(route('chat.push.subscribe'), [
            'subscription' => [
                'endpoint' => 'https://fcm.googleapis.com/fcm/send/test-endpoint',
                'keys' => [
                    'p256dh' => 'test-p256dh-key',
                    'auth' => 'test-auth-token',
                ],
            ],
            'content_encoding' => 'aesgcm',
        ])
        ->assertOk()
        ->assertJson(['ok' => true]);

    $this->assertDatabaseHas('chat_push_subscriptions', [
        'discord_user_id' => 'discord-member-push',
        'endpoint_hash' => hash('sha256', 'https://fcm.googleapis.com/fcm/send/test-endpoint'),
        'content_encoding' => 'aesgcm',
    ]);
});

test('discord members can unsubscribe chat push notifications', function () {
    config()->set('services.webpush.public_key', 'test-public-key');
    config()->set('services.webpush.private_key', 'test-private-key');
    config()->set('services.webpush.subject', 'https://lyvacommunity.test');

    $this->withSession(discordMemberSessionForPush())
        ->postJson(route('chat.push.subscribe'), [
            'subscription' => [
                'endpoint' => 'https://fcm.googleapis.com/fcm/send/test-endpoint-2',
                'keys' => [
                    'p256dh' => 'test-p256dh-key-2',
                    'auth' => 'test-auth-token-2',
                ],
            ],
            'content_encoding' => 'aesgcm',
        ])
        ->assertOk();

    $this->withSession(discordMemberSessionForPush())
        ->deleteJson(route('chat.push.unsubscribe'), [
            'endpoint' => 'https://fcm.googleapis.com/fcm/send/test-endpoint-2',
        ])
        ->assertOk()
        ->assertJson(['ok' => true]);

    $this->assertDatabaseMissing('chat_push_subscriptions', [
        'endpoint_hash' => hash('sha256', 'https://fcm.googleapis.com/fcm/send/test-endpoint-2'),
    ]);
});

function discordMemberSessionForPush(): array
{
    return [
        DiscordAuthService::SESSION_KEY => [
            'id' => 'discord-member-push',
            'name' => 'Lyva Push Member',
            'username' => 'lyvapushmember',
            'avatar_url' => null,
            'is_core_member' => false,
            'primary_role' => null,
            'redirect_to' => route('home'),
        ],
    ];
}
