<?php

return [
    // 抖音开放平台
    'platform' => [

        'client_key' => env('BYTEDANCE_PLATFORM_CLIENT_KEY', ''),
        'client_secret' => env('BYTEDANCE_PLATFORM_CLIENT_SECRET', ''),
        // 授权回调
        'url' => env('BYTE_URL', ''),
    ],
    // 小程序
    'microapp' => [
        'appid' => env('BYTEDANCE_MICROAPP_APPID', ''),
        'secret' => env('BYTEDANCE_MICROAPP_SECRET', ''),
    ],
];
