<?php

return [

    'client_key' => env('BYTE_CLIENT_KEY', ''),

    'client_secret' => env('BYTE_CLIENT_SECRET', ''),
    // 授权回调
    'url' => env('BYTE_URL', ''),

    'weapp' => [
        'appid' => env('BYTE_WEAPP_APPID', ''),
        'secret' => env('BYTE_WEAPP_SECRET', ''),
    ],
];
