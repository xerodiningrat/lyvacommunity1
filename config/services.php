<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'discord' => [
        'invite_url' => env('DISCORD_INVITE_URL', 'https://discord.gg/7grEUp6m'),
        'client_id' => env('DISCORD_CLIENT_ID'),
        'client_secret' => env('DISCORD_CLIENT_SECRET'),
        'redirect_uri' => env('DISCORD_REDIRECT_URI'),
        'bot_token' => env('DISCORD_BOT_TOKEN'),
        'gallery_channel_id' => env('DISCORD_GALLERY_CHANNEL_ID'),
        'gallery_limit' => (int) env('DISCORD_GALLERY_LIMIT', 5),
        'cache_ttl_seconds' => (int) env('DISCORD_CACHE_TTL_SECONDS', 300),
        'leadership_roles' => [
            [
                'id' => '1425164984056549459',
                'label' => 'Founder',
                'group' => 'Owner',
                'badge_class' => 'ro',
                'icon' => '👑',
                'priority' => 10,
            ],
            [
                'id' => '1454766615743954955',
                'label' => 'Co-Owner',
                'group' => 'Owner',
                'badge_class' => 'ro',
                'icon' => '👑',
                'priority' => 20,
            ],
            [
                'id' => '1455302998283784483',
                'label' => 'Community Manager',
                'group' => 'Admin',
                'badge_class' => 'ra',
                'icon' => '💼',
                'priority' => 30,
            ],
            [
                'id' => '1454086035805049044',
                'label' => 'Community Leader',
                'group' => 'Admin',
                'badge_class' => 'ra',
                'icon' => '⚜️',
                'priority' => 40,
            ],
            [
                'id' => '1453569126902665226',
                'label' => 'Community Queen',
                'group' => 'Admin',
                'badge_class' => 'ra',
                'icon' => '🌸',
                'priority' => 50,
            ],
            [
                'id' => '1454773302273904711',
                'label' => 'LYVA Team',
                'group' => 'Staff',
                'badge_class' => 'rm',
                'icon' => '🛡️',
                'priority' => 60,
            ],
            [
                'id' => '1425164984056549458',
                'label' => 'Lead Moderator',
                'group' => 'Staff',
                'badge_class' => 'rm',
                'icon' => '🛡️',
                'priority' => 70,
            ],
            [
                'id' => '1455303746039971933',
                'label' => 'Developer',
                'group' => 'Staff',
                'badge_class' => 'rm',
                'icon' => '💻',
                'priority' => 80,
            ],
        ],
        'leadership_hidden_user_ids' => [
            '1414976447659118595',
        ],
    ],

    'webpush' => [
        'public_key' => env('VAPID_PUBLIC_KEY'),
        'private_key' => env('VAPID_PRIVATE_KEY'),
        'subject' => env('VAPID_SUBJECT', env('APP_URL')),
    ],

];
