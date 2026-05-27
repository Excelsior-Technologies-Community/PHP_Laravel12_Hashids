<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Hashids Connection
    |--------------------------------------------------------------------------
    */
    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    */
    'connections' => [
        'main' => [
            'salt' => env('HASHIDS_SALT', env('APP_KEY')),
            'length' => 10,
            'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        ],
        
        // New connection for user IDs
        'users' => [
            'salt' => env('HASHIDS_USER_SALT', 'user_salt_2026_secret'),
            'length' => 12,
            'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        ],
        
        // New connection for orders
        'orders' => [
            'salt' => env('HASHIDS_ORDER_SALT', 'order_salt_2026_secure'),
            'length' => 15,
            'alphabet' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        ],
    ],
];