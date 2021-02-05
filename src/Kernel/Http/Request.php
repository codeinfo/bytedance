<?php

/**
 * This file is part of the codeinfo/ByteDanceLaravel.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ByteDanceLaravel\Kernel\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;

class Request
{
    protected $timeout = 20.0;

    protected $verify;

    public function __construct()
    {
    }

    /**
     * 初始化Client.
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
     * init Options.
     *
     * @param array $options
     * @return array
     */
    protected static function initOptions($options): array
    {
        if (! is_array($options)) {
            throw new InvalidArgumentException('options must be array');
        }

        return array_merge($options, [
            'debug' => false,
        ]);
    }

    /**
     * make request.
     *
     * @param string $url
     * @param string $method
     * @param array $options
     * @return \GuzzleHttp\Psr7\Response
     */
    public function request($url, $method = 'GET', $options = [], $returnRaw = false): Response
    {
        $method = strtoupper($method);

        return $this->baseClient()->request($method, $url, self::initOptions($options));
    }
}
