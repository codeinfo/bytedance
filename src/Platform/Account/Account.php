<?php

/**
 * This file is part of the Codeinfo\LaravelBytedance.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Codeinfo\LaravelBytedance\Platform\Account;

use Codeinfo\LaravelBytedance\Kernel\Client;

class Account extends Client
{
    protected $baseUri = 'https://open.douyin.com';

    /**
     * 获取用户信息.
     *
     * @param string $open_id
     * @param string $access_token token每个用户一个
     * @return array
     */
    public function userInfo(string $open_id, string $access_token)
    {
        $query = [
            'access_token' => $access_token,
            'open_id' => $open_id,
        ];

        $response = $this->httpGet('/oauth/userinfo/', $query);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 解密手机号.
     *
     * @param string $string
     * @return string
     */
    public function decryptMobile(string $string)
    {
        $key = $this->app['config']['client_secret'];
        $iv = substr($key, 0, 16);

        return openssl_decrypt(base64_decode($string), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * 解析抖音主页.
     *
     * @return void
     */
    public function getRedirectUrl(string $url)
    {
        $response = $this->httpGetRedirect($url);

        $redriect_url = $response->getHeaderLine('X-Guzzle-Redirect-History');

        return $redriect_url;
    }

    public function getHomePageUserInfo($sec_uid)
    {
        $query = [
            'sec_uid' => $sec_uid,
        ];

        $this->baseUri = 'https://www.iesdouyin.com';

        $response = $this->httpGet('/web/api/v2/user/info/', $query);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getPoiInfo($poi_id)
    {
        $query = [
            'poi_id' => $poi_id,
        ];

        $this->baseUri = 'https://www.iesdouyin.com';

        $response = $this->httpGet('/web/api/v2/poi/detail/', $query);

        return json_decode($response->getBody()->getContents(), true);
    }
}
