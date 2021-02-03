<?php

namespace ByteDanceLaravel\Platform\Oauth;

class AccessToken
{
    protected $baseUri = 'https://open.douyin.com';

    protected $endpoint = '/oauth/access_token/';

    public function getAccessToken($code, $grant_type = 'authorization_code')
    {
        // 抖音初始化
        $client_key = $this->client_key; // string | 应用唯一标识
        $client_secret = $this->client_secret; // string | 应用唯一标识对应的密钥

        $url = $this->baseUri . $this->endpoint;

        $query = 'client_key=' . $client_key . '&client_secret=' . $client_secret . '&code=' . $code . '&grant_type='
            . $grant_type;

        $options = [
            'query' => $query,
        ];

        $response = $this->request->httpGet($url, $options);

        // if ($result->data->error_code != 0) {
        //     throw new ResponseException($result->data->description);
        // }

        return json_decode($response->getBody()->getContents(), true);
    }
}
