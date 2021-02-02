<?php

namespace Codeinfo\Bytedance\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Facades\Log;

class Request
{
    public $client;

    protected $timeout = 20.0;

    protected $verify;

    public function __construct()
    {
        $this->initClient();
    }

    /**
     * init Client.
     *
     * @return mixed
     */
    protected function initClient()
    {
        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler);

        $this->client = new Client([
            'timeout' => $this->timeout,
            'verify'  => $this->verify,
            'handler' => $stack,
        ]);
    }

    protected static function initOptions($options)
    {
        if (!is_array($options)) {
            throw new \Exception('options must be array');
        }

        return array_merge($options, [
            'debug' => false,
        ]);
    }

    /**
     * 请求服务器.
     *
     * @param [type] $url
     * @param string $method
     * @param array  $options
     *
     * @return mixed
     */
    public function httpGet($url, $options = [])
    {
        try {
            $response = $this->client->request('GET', $url, self::initOptions($options));
        } catch (RequestException $e) {
            // 写入日志
            if ($e->hasResponse()) {
                // 写入日志
                Log::error('curlGuzzleHttp', [$e->getResponse()]);
            }
        }

        if ($response->getStatusCode() === 200) {
            $content = $response->getBody()->getContents();
        } else {
            return false;
        }

        return json_decode($content);
    }

    /**
     * POST请求
     *
     * @param [type] $url
     * @param array  $options
     *
     * @return void
     */
    public static function post($url, $options = [])
    {
        $client = new Client([
            // You can set any number of default request options.
            'timeout' => 20.0,
            'verify'  => false,
        ]);

        $options = array_merge($options, [
            'debug' => false,
        ]);

        try {
            $response = $client->request('POST', $url, $options);
        } catch (RequestException $e) {
            // 写入日志
            if ($e->hasResponse()) {
                // 写入日志
                Log::channel('single')->info('curlGuzzleHttp', [$e->getResponse()]);
            }
        }

        if ($response->getStatusCode() === 200) {
            $content = $response->getBody()->getContents();
        } else {
            return false;
        }

        return $content;
    }
}
