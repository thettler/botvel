<?php

return [
    'default_bot' => 'default',

    'platforms' => [
        'discord' => [

        ],
    ],

    'bots' => [
        'default' => [
            'platforms' => [
                'discord' => [
                    'application_id' => env('DISCORD_DEFAULT_APPLICATION_ID', null),
                    'bot_token' => env('DISCORD_DEFAULT_BOT_TOKEN', null),
                    'public_key' => env('DISCORD_DEFAULT_PUBLIC_KEY', null),
                ],
            ],

        ],
    ],

    'store' => \Thettler\Botvel\Stores\MemoryStore::class,
];
