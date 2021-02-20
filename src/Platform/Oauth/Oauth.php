<?php

/**
 * This file is part of the codeinfo/ByteDanceLaravel.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ByteDanceLaravel\Platform\Oauth;

use ByteDanceLaravel\Kernel\Client;

class Oauth extends Client
{
    protected $baseUri = 'https://open.douyin.com';

    /**
     * 生成用户授权地址
     *
     * @param string $scope
     * @param string $redirect_uri
     * @return string
     */
    public function genrateUrl(string $scope, string $redirect_uri)
    {
        $query = [
            'client_key' => $this->app['config']['client_key'],
            'response_type' => 'response_type',
            'scope' => $scope,
            'redirect_uri' => $redirect_uri,
        ];

        $url = $this->baseUri.'/platform/oauth/connect/?';

        foreach ($query as $key => $value) {
            $url .= '&'.$key.'='.$value;
        }

        return $url;
    }

    /**
     * 生成用户静默授权地址
     *
     * @param string $redirect_uri
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
            $url .= '&'.$key.'='.$value;
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
        $url = $this->baseUri.'/oauth/access_token/';

        $query = [
            'client_key' => $this->app['config']['client_key'],
            'client_secret' => $this->app['config']['client_secret'],
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];

        $response = $this->httpGet($url, $query);

        return json_decode($response->getBody()->getContents(), true);
    }
}
