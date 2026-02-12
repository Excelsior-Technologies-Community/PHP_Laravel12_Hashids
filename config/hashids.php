<?php

return [

    'default' => 'main',

    'connections' => [

        'main' => [
            'salt' => env('HASHIDS_SALT', env('APP_KEY')),
            'length' => 10,
            'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
        ],

    ],

];


