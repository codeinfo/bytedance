<?php

/**
 * This file is part of the Codeinfo\LaravelBytedance.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Codeinfo\LaravelBytedance\Kernel;

use Codeinfo\LaravelBytedance\Kernel\Http\Request;

class Client extends Request
{
    /**
     * ServiceContainer.
     *
     * @var \Codeinfo\LaravelBytedance\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * Client constructor.
     *
     * @param \Codeinfo\LaravelBytedance\Kernel\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        parent::__construct();

        $this->app = $app;
    }

    /**
     * Http Get.
     *
     * @param string $url
     * @param array $query
     * @return mixed
     */
    public function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', ['query' => $query]);
    }

    /**
     * Http Post Json.
     *
     * @param string $url
     * @param array $data
     * @return mixed
     */
    public function httpPostJson(string $url, array $query = [], array $json = [])
    {
        return $this->request($url, 'POST', [
            'query' => $query,
            'json' => $json,
        ]);
    }

    /**
     * Http get redirect.
     *
     * @param string $url
     * @return mixed
     */
    public function httpGetRedirect(string $url)
    {
        return $this->request($url, 'GET', [
            'allow_redirects' => [
                'track_redirects' => true,
            ],
        ]);
    }

    /**
     * Http Post Upload video for mp4.
     *
     * @param string $url
     * @param array $query
     * @param string $video_path
     * @return mixed
     */
    public function httpPostUpload($url, array $query, string $type, string $video_path)
    {
        $options = [
            'query' => $query,
            'multipart' => [
                [
                    'name' => $type,
                    'contents' => fopen($video_path, 'r'),
                    'headers' => [
                        'Content-Type' => 'multipart/form-data',
                    ],
                ],
            ],
        ];

        return $this->request($url, 'POST', $options);
    }
}
