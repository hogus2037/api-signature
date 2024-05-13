<?php

return [
    'default' => env('SIGN_DEFAULT', 'api'),

    'guards' => [
        'api' => [
            'driver' => 'MD5',
            'enabled' => env('API_SIGN_ENABLED', true),
            'secret' => env('API_SIGN_SECRET', 'secret'),
            'sign_key' => env('API_SIGN_KEY', 'sign'),
            'timestamp_key' => env('API_SIGN_TIMESTAMP_KEY', 'timestamp'),
            'timeout' => env('API_SIGN_TIMEOUT', 0),
        ],
        // admin
        // 'admin' => [
        //     'driver' => 'hash',
        //     'algo' => env('ADMIN_SIGN_HASH_ALGO', 'sha256'),
        //     'enabled' => env('ADMIN_SIGN_ENABLED', true),
        //     'secret' => env('ADMIN_SIGN_SECRET', 'secret'),
        //     'sign_key' => env('ADMIN_SIGN_KEY', 'sign'),
        //     'timestamp_key' => env('ADMIN_SIGN_TIMESTAMP_KEY', 'timestamp'),
        //     'timeout' => env('ADMIN_SIGN_TIMEOUT', 0),
        // ],
    ]
];
