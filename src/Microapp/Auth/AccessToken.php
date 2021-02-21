<?php

/**
 * This file is part of the codeinfo/ByteDanceLaravel.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ByteDanceLaravel\Microapp\Auth;

use ByteDanceLaravel\Kernel\Client;
use ByteDanceLaravel\Kernel\Exceptions\InvalidArgumentException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class AccessToken extends Client
{
    protected $baseUri = 'https://developer.toutiao.com/api';

    protected $cachePrefix = 'ByteWeapp-';

    protected $access_token;

    public function __construct($app)
    {
        parent::__construct($app);
        $this->access_token = $this->getAccessToken();
    }

    /**
     * 登陆.
     *
     * @param string $code
     * @param string $anonymous_code 匿名
     * @return void
     */
    public function code2Session($data)
    {
        $query = array_merge($this->app['config'], [
            'grant_type' => 'client_credential',
        ]);

        if (Arr::has($data, 'code') || Arr::has($data, 'anonymous_code')) {
            $query = array_merge($query, $data);
        } else {
            throw new InvalidArgumentException('code 和 anonymous_code 至少要有一个');
        }

        $response = $this->httpGet('/apps/jscode2session', $query);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 创建二维码
     *
     * @param array $form_params
     * @return stream 图片流
     */
    public function createQRCode(string $path)
    {
        $json = [
            'access_token' => $this->access_token,
            'appname' => 'douyin',
            'path' => $path,
        ];

        $response = $this->httpPostJson('/apps/qrcode', [], $json);

        return $response->getBody()->getContents();
    }

    /**
     * 获取 access_token.
     *
     * @return string
     */
    private function getAccessToken()
    {
        return Cache::remember($this->cachePrefix . 'access_token', 7200, $this->getToken());
    }

    /**
     * 获取token.
     *
     * @return \Closure
     */
    private function getToken(): \Closure
    {
        return function () {

            $query = array_merge($this->app['config'], [
                'grant_type' => 'client_credential',
            ]);

            $response = $this->httpGet('/apps/token', $query);
            $result = json_decode($response->getBody()->getContents(), true);

            return $result['access_token'];
        };
    }
}
