<?php
namespace Codeinfo\Bytedance;

use App\Exceptions\CustomException;
use App\Services\Byte\Guzzle\Http;
use Codeinfo\Bytedance\Contracts\WeappInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class WeappService implements WeappInterface
{
    protected $config;

    protected $cachePrefix = 'microapp-';

    protected $access_token;

    public function __construct($config)
    {
        $this->config = $config;
        $this->access_token = $this->getAccessToken();
    }

    /**
     * 获取 access_token
     *
     * @return string
     */
    private function getAccessToken()
    {
        return Cache::remember($this->cachePrefix . 'access_token', 7200, function () {

            $url = 'https://developer.toutiao.com/api/apps/token';

            $options = [
                'query' => array_merge($this->config, [
                    'grant_type' => 'client_credential',
                ]),
            ];

            $result = Http::request($url, 'GET', $options);

            return $result->access_token;
        });
    }

    /**
     * 登陆
     *
     * @param string $code
     * @param string $anonymous_code 匿名
     * @return void
     */
    public function code2Session($data)
    {
        $url = 'https://developer.toutiao.com/api/apps/jscode2session';

        $query = array_merge($this->config, [
            'grant_type' => 'client_credential',
        ]);

        if (Arr::has($data, 'code') || Arr::has($data, 'anonymous_code')) {
            $query = array_merge($query, $data);
        } else {
            throw new CustomException('code 和 anonymous_code 至少要有一个', 201);
        }

        $options = [
            'query' => $query,
        ];

        return Http::request($url, 'GET', $options);
    }

    /**
     * 创建二维码
     *
     * @param Array $form_params
     * @return mixed
     */
    public function createQRCode($form_params = [])
    {
        $url = 'https://developer.toutiao.com/api/apps/qrcode';

        $options = [
            'json' => array_merge($form_params, [
                'access_token' => $this->access_token,
                'appname' => 'douyin',
            ]),
        ];

        return Http::post($url, $options);
    }
}
