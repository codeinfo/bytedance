<?php

namespace Codeinfo\Bytedance\Http;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;

class Request
{
    protected $timeout = 20.0;

    protected $verify;

    /**
     * 初始化Client
     *
     * @return \GuzzleHttp\Client
     */
    protected function baseClient(): Client
    {
        $handler = new CurlHandler();
        $stack = HandlerStack::create($handler);

        return new Client([
            'timeout' => $this->timeout,
            'verify' => $this->verify,
            'handler' => $stack,
        ]);
    }

    /**
     * init Options
     *
     * @param array $options
     * @return array
     */
    protected static function initOptions($options): array
    {
        if (!is_array($options)) {
            throw new InvalidArgumentException('options must be array');
        }

        return array_merge($options, [
            'debug' => false,
        ]);
    }

    /**
     * make request
     *
     * @param string $url
     * @param string $method
     * @param array $options
     * @return \GuzzleHttp\Psr7\Response
     */
    public function request($url, $method = "GET", $options = [], $returnRaw = false): Response
    {
        $method = strtoupper($method);

        return $this->baseClient()->request($method, $url, self::initOptions($options));
    }

    /**
     * Undocumented function
     *
     * @param [type] $url
     * @param array $options
     * @return Response
     */
    public function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    public function httpPost(string $url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }

}
