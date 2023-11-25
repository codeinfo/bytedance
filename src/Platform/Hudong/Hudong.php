<?php

namespace Codeinfo\LaravelBytedance\Platform\Hudong;

use Codeinfo\LaravelBytedance\Kernel\Client;
use Codeinfo\LaravelBytedance\Kernel\ServiceContainer;

class Hudong extends Client
{
    protected $baseUri = 'https://open.douyin.com';

    /**
     * 发送私信
     * @param $open_id [企业号open_id]
     * @param $access_token [企业号token]
     * @param $params
     * @return mixed
     */
    public function sendMsg($open_id, $access_token, $params)
    {
        $response = $this->httpPost('/im/send/msg/?open_id=' . $open_id, $params, ['access-token' => $access_token, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 回复视频评论
     * @param $open_id
     * @param $access_token
     * @param $params
     */
    public function commentReply($open_id, $access_token, $params)
    {
        $response = $this->httpPost('/item/comment/reply/?open_id=' . $open_id, $params, ['access-token' => $access_token, 'Content-Type' => 'application/json']);
    }
}
