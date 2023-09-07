<?php

/**
 * This file is part of the Codeinfo\LaravelBytedance.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Codeinfo\LaravelBytedance\Platform\Oauth;

use Codeinfo\LaravelBytedance\Kernel\Client;
use Illuminate\Support\Facades\Cache;

class Oauth extends Client
{
    protected $baseUri = 'https://open.douyin.com';

    /**
     * 生成用户授权地址
     *
     * @param string $scope
     * @param string $redirect_uri
     * @param string $state
     * @return string
     */
    public function genrateUrl(string $scope, string $redirect_uri, string $state = '')
    {
        $query = [
            'client_key' => $this->app['config']['client_key'],
            'response_type' => 'code',
            'scope' => $scope,
            'redirect_uri' => $redirect_uri,
        ];
        if (!blank($state)) {
            $query['state'] = $state;
        }

        $url = $this->baseUri . '/platform/oauth/connect/?';

        foreach ($query as $key => $value) {
            $url .= '&' . $key . '=' . $value;
        }

        return $url;
    }

    /**
     * 生成用户静默授权地址
     *
     * @param string $redirect_uri
     * @param string|null $state
     * @return string
     */
    public function genrateBaseUrl(string $redirect_uri, string $state = null)
    {
        $query = [
            'client_key' => $this->client_key,
            'response_type' => 'code',
            'scope' => 'login_id',
            'state' => $state ?? '',
            'redirect_uri' => $redirect_uri,
        ];

        $url = 'https://aweme.snssdk.com/oauth/authorize/v2/?';

        foreach ($query as $key => $value) {
            $url .= '&' . $key . '=' . $value;
        }

        return $url;
    }

    /**
     * 获取用户授权token.
     *
     * @param string $code
     * @return array
     */
    public function getAccessToken(string $code)
    {
        $query = [
            'client_key' => $this->app['config']['client_key'],
            'client_secret' => $this->app['config']['client_secret'],
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];

        $response = $this->httpGet('/oauth/access_token/', $query);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 刷新用户token
     * @param string $refresh_token
     * @return mixed
     */
    public function refreshToken(string $refresh_token)
    {
        $query = [
            'client_key' => $this->app['config']['client_key'],
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token
        ];

        $response = $this->httpGet('/oauth/refresh_token/', $query);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 刷新用户 refresh_token
     * @param string $refresh_token
     * @return mixed
     */
    public function renewRefreshToken(string $refresh_token)
    {
        $query = [
            'client_key' => $this->app['config']['client_key'],
            'refresh_token' => $refresh_token
        ];

        $response = $this->httpGet('/oauth/renew_refresh_token/', $query);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 获取应用全局token 两小时刷新.
     *
     * @return array
     */
    public function clientToken()
    {
        $query = [
            'client_key' => $this->app['config']['client_key'],
            'client_secret' => $this->app['config']['client_secret'],
            'grant_type' => 'client_credential',
        ];
        $key = sprintf($this->app['config']['cache_client_access_token_key'], $this->app['config']['client_key']);

//        $accessToken = Cache::remember($key, 5000, function () use ($query) {
        $response = $this->httpGet('/oauth/client_token/', $query);

        $data = json_decode($response->getBody()->getContents(), true);

        $accessToken =  $data['data']['access_token'];
//        });
//
        return $accessToken;
    }

    /**
     * 获取票据.
     *
     * @return void
     */
    public function getTicket()
    {
        // Cache::tags('bytedance')->has('client_token');
        $query = [
            'access_token' => 'clt.96f1323d85d6ab3e0cf2d2830b7c6b3dI5DoIRVmgTz7eowk2v5ESPitdLLt',
        ];

        $response = $this->httpGet('/js/getticket/', $query);

        return json_decode($response->getBody()->getContents(), true);
    }
}
