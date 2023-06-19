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

    /**
     * 查询商品线上数据
     * @param array $params
     * @return mixed
     */
    public function productOnlineGet(array $params)
    {
        $response = $this->httpGet('/goodlife/v1/goods/product/online/get/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 上下架
     * @return mixed
     */
    public function goodsProductOperate($params)
    {
        $response = $this->httpPost('/goodlife/v1/goods/product/operate/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

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

    //代运营相关

    /**
     * 合作列表获取
     * @param array $params
     * @return mixed
     */
    public function partnerOrderList(array $params)
    {
        $response = $this->httpGet('/goodlife/v1/partner/order/query/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 同步库存
     * @param $params
     * @return mixed
     */
    public function goodsStockSync($params)
    {
        $response = $this->httpGet('/goodlife/v1/goods/stock/sync/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 合作详情查询
     * @param array $params
     * @return mixed
     */
    public function partnerOrderGet(array $params)
    {
        $response = $this->httpGet('/goodlife/v1/partner/order/get/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 创建合作关系
     * @param $params
     * @return mixed
     */
    public function partnerOrderCreate($params)
    {
        $response = $this->httpPost('/goodlife/v1/partner/order/create/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 创建/修改佣金
     * @param $params
     * @return mixed
     */
    public function partnerProductCommission($params)
    {
        $response = $this->httpPost('/goodlife/v1/partner/product_commission/save/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 佣金变更记录列表
     * @param $params
     * @return mixed
     */
    public function partnerCommissionRecordQuery($params)
    {
        $response = $this->httpGet('/goodlife/v1/partner/commission_record/query/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 佣金变更记录详情
     * @param $params
     * @return mixed
     */
    public function partnerCommissionRecordGet($params)
    {
        $response = $this->httpGet('/goodlife/v1/partner/commission_record/get/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 商品佣金详情
     * @param $params
     * @return mixed
     */
    public function partnerProductCommissionQuery($params)
    {
        $response = $this->httpGet('/partner/product_commission/query/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 发起店铺匹配 POI 同步任务
     * @param $params
     * @return mixed
     */
    public function poiSupplierMatch($params)
    {
        $response = $this->httpPost('/poi/v2/supplier/match/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 店铺匹配任务结果查询
     * @param $params
     * @return mixed
     */
    public function poiSupplierQueryTask($params)
    {
        $response = $this->httpGet('/poi/v2/supplier/query/task/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 商铺同步
     * @param $params
     * @return mixed
     */
    public function poiSupplierSync($params)
    {
        $response = $this->httpPost('/poi/supplier/sync/', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }

    //
    public function queryOrder($params)
    {
        $response = $this->httpPost('/api/apps/trade/v2/order/query_order', $params, ['access-token' => $this->accessToken, 'Content-Type' => 'application/json']);

        return json_decode($response->getBody()->getContents(), true);
    }
}
