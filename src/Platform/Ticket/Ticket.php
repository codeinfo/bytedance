<?php

namespace Codeinfo\LaravelBytedance\Platform\Ticket;

use Codeinfo\LaravelBytedance\Kernel\Client;

class Ticket extends Client
{
    protected $baseUri = 'https://open.douyin.com';

    public function getOpenTicket($access_token)
    {
        $response = $this->httpGet('/open/getticket/', [], ['access-token' => $access_token]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
