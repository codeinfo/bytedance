<?php

return [
    // 抖音开放平台
    'platform' => [

        'client_key' => env('BYTEDANCE_PLATFORM_CLIENT_KEY', ''),

        'client_secret' => env('BYTEDANCE_PLATFORM_CLIENT_SECRET', ''),
        //client_access_token 缓存key
        'cache_client_access_token_key' => 'client_access_token_%s',
        // 授权回调
        'url' => env('BYTE_URL', ''),

    ],
    // 小程序
    'microapp' => [

        'appid' => env('BYTEDANCE_MICROAPP_APPID', ''),

        'secret' => env('BYTEDANCE_MICROAPP_SECRET', ''),

    ],

    'http' => [

        'timeout' => 60.0,

    ],
];
