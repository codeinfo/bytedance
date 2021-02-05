<?php

/**
 * This file is part of the codeinfo/ByteDanceLaravel.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ByteDanceLaravel\Platform\Account;

use ByteDanceLaravel\Kernel\Client;

class Account extends Client
{
    protected $baseUri = 'https://open.douyin.com';

    /**
     * 获取用户信息
     *
     * @param string $open_id
     * @param string $access_token token每个用户一个
     * @return array
     */
    public function userInfo(string $open_id, string $access_token)
    {
        $url = $this->baseUri . '/oauth/userinfo/';

        $query = [
            'access_token' => $access_token,
            'open_id' => $open_id,
        ];

        $response = $this->httpGet($url, $query);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 解密手机号
     *
     * @param string $string
     * @return string
     */
    public function decryptMobile($string)
    {
        $key = $this->app['config']['client_key'];
        $iv = substr($key, 0, 16);
        return openssl_decrypt(base64_decode($string), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * 解析抖音主页
     *
     * @return void
     */
    public function getDouyinUid(string $url)
    {
        // 发起请求查询实际用户主页ID
        $options = [
            'allow_redirects' => [
                'track_redirects' => true,
            ],
        ];

        $response = $this->httpGet($url, $options);

        $redrict_url = $response->getHeaderLine('X-Guzzle-Redirect-History');

        dd($redrict_url);
        // 解析地址
        return explode('/', parse_url($redrict_url)['path'])[3];
    }
}
