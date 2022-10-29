<?php

namespace Codeinfo\LaravelBytedance\Platform\Life;

use Codeinfo\LaravelBytedance\Kernel\Client;
use Codeinfo\LaravelBytedance\Kernel\ServiceContainer;
use Illuminate\Support\Facades\Cache;

class Life extends Client
{
    protected $baseUri = 'https://open.douyin.com';

    protected $accessToken;

    public function __construct(ServiceContainer $app)
    {
        parent::__construct($app);

        $this->accessToken = $this->app->oauth->clientToken();
    }

    /**
     * 订单
     * @param $access_token
     * @param array $params
     * @return mixed
     */
    public function orderQuery(array $params)
    {
        $response = $this->httpGet('/goodlife/v1/trade/order/query/', $params, ['access-token' => $this->accessToken]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 验券历史查询
     * @param $access_token
     * @param array $params
     * @return mixed
     */
    public function verifyRecord(array $params)
    {
        $response = $this->httpGet('/goodlife/v1/fulfilment/certificate/verify_record/query/', $params, ['access-token' => $this->accessToken]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 分账明细查询
     * @param $access_token
     * @param array $params
     * @return mixed
     */
    public function queryRecordByCert(array $params)
    {
        $response = $this->httpGet('/goodlife/v1/settle/ledger/query_record_by_cert/', $params, ['access-token' => $this->accessToken]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
