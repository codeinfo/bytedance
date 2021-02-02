<?php

namespace Codeinfo\Bytedance\Traits\Platform;

trait Oauth
{
    public function getOauthToken($code, $grant_type = 'authorization_code')
    {
        // 抖音初始化
        $client_key = $this->client_key; // string | 应用唯一标识
        $client_secret = $this->client_secret; // string | 应用唯一标识对应的密钥

        $url = 'https://open.douyin.com/oauth/access_token/';

        $query = 'client_key=' . $client_key . '&client_secret=' . $client_secret . '&code=' . $code . '&grant_type='
            . $grant_type;

        $options = [
            'query' => $query,
        ];

        $result = $this->request->httpGet($url, $options);

        dd($result);

        // if ($result->data->error_code != 0) {
        //     throw new ResponseException($result->data->description);
        // }

        return $result;
    }
}
