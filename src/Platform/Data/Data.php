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
}
