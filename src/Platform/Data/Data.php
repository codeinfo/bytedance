<?php

namespace Codeinfo\LaravelBytedance\Platform\Data;

use Codeinfo\LaravelBytedance\Kernel\Client;

class Data extends Client
{

    protected $baseUri = 'https://open.douyin.com';


    public function topic($access_token)
    {
        $response = $this->httpGet('/data/extern/billboard/topic/', [], ['access-token' => $access_token]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function userFans($access_token, $open_id, $date_type = 7)
    {
        $response = $this->httpGet('/data/external/user/fans/', ['open_id' => $open_id, 'date_type' => $date_type], ['access-token' => $access_token]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function userLike($access_token, $open_id, $date_type = 7)
    {
        $response = $this->httpGet('/data/external/user/like/', ['open_id' => $open_id, 'date_type' => $date_type], ['access-token' => $access_token]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function userComment($access_token, $open_id, $date_type = 7)
    {
        $response = $this->httpGet('/data/external/user/comment/', ['open_id' => $open_id, 'date_type' => $date_type], ['access-token' => $access_token]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function userShare($access_token, $open_id, $date_type = 7)
    {
        $response = $this->httpGet('/data/external/user/share/', ['open_id' => $open_id, 'date_type' => $date_type], ['access-token' => $access_token]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function userProfile($access_token, $open_id, $date_type = 7)
    {
        $response = $this->httpGet('/data/external/user/profile/', ['open_id' => $open_id, 'date_type' => $date_type], ['access-token' => $access_token]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function userItem($access_token, $open_id, $date_type = 7)
    {
        $response = $this->httpGet('/data/external/user/item/', ['open_id' => $open_id, 'date_type' => $date_type], ['access-token' => $access_token]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
