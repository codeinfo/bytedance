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
        $response = $this->httpGet('/goodlife/v1/fulfilment/certificate/verify_record/query/', [], $params, ['access-token' => $this->accessToken]);

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

    /**
     * 商品线上数据列表
     * @param array $params
     * @return mixed
     */
    public function goodsList(array $params)
    {
        $response = $this->httpGet('/goodlife/v1/goods/product/online/query/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function goodsTemplate(array $params)
    {
        $response = $this->httpGet('/goodlife/v1/goods/template/get/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 查询商品品类
     * @return mixed
     */
    public function goodsCategory($params)
    {
        $response = $this->httpGet('/goodlife/v1/goods/category/get/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 门店信息查询
     * @param $params
     * @return mixed
     */
    public function shopPoi($params)
    {
        $response = $this->httpGet('/goodlife/v1/shop/poi/query/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 创建/修改团购活动
     * @param $params
     * @return mixed
     */
    public function goodsProductSave($params)
    {
        $response = $this->httpPost('/goodlife/v1/goods/product/save/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 免审修改商品
     * @param $params
     * @return mixed
     */
    public function goodsProductFreeAudit($params)
    {
        $response = $this->httpPost('/goodlife/v1/goods/product/free_audit/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function certificateDetail(array $params)
    {
        $response = $this->httpGet('/goodlife/v1/fulfilment/certificate/get/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }
}
