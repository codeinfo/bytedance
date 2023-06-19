<?php

/**
 * This file is part of the Codeinfo\LaravelBytedance.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Codeinfo\LaravelBytedance\Microapp\Auth;

use Codeinfo\LaravelBytedance\Kernel\Client;
use Codeinfo\LaravelBytedance\Kernel\Exceptions\Exception;
use Codeinfo\LaravelBytedance\Kernel\Exceptions\InvalidArgumentException;
use Codeinfo\LaravelBytedance\Kernel\Support\AES;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class AccessToken extends Client
{
    protected $baseUri = 'https://developer.toutiao.com';

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
     * @param  string  $code
     * @param  string  $anonymous_code  匿名
     * @return void
     */
    public function code2Session($data)
    {
        $json = array_merge($this->app['config'], [
            'grant_type' => 'client_credential',
        ]);

        if (Arr::has($data, 'code') || Arr::has($data, 'anonymous_code')) {
            $json = array_merge($json, $data);
        } else {
            throw new InvalidArgumentException('code 和 anonymous_code 至少要有一个');
        }

        $response = $this->httpPostJson('/api/apps/v2/jscode2session', [], $json);
        $result = json_decode($response->getBody()->getContents(), true);

        return $result['data'];
    }

    /**
     * 创建二维码
     *
     * @param  array  $form_params
     * @return stream 图片流
     */
    public function createQRCode(string $path)
    {
        $json = [
            'access_token' => $this->access_token,
            'appname' => 'douyin',
            'path' => $path,
        ];

        $response = $this->httpPostJson('/api/apps/qrcode', [], $json);

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
            $json = array_merge($this->app['config'], [
                'grant_type' => 'client_credential',
            ]);

            $response = $this->httpPostJson('/api/apps/v2/token', [], $json);
            $result = json_decode($response->getBody()->getContents(), true);

            return $result['data']['access_token'];
        };
    }

    /**
     * 解密敏感数据
     * @param  string  $encryptedData
     * @param  string  $sessionKey
     * @param  string  $iv
     * @return array
     */
    private function decryptData(string $encryptedData, string $sessionKey, string $iv): array
    {
        $decrypted = AES::decrypt(
            base64_decode($encryptedData, false),
            base64_decode($sessionKey, false),
            base64_decode($iv, false),
        );

        return json_decode($decrypted, true);
    }
}
