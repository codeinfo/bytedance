<?php

/**
 * This file is part of the codeinfo/ByteDanceLaravel.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ByteDanceLaravel\Kernel;

use ByteDanceLaravel\Kernel\Http\Request;

class Client extends Request
{
    /**
     * 服务容器
     *
     * @var \ByteDanceLaravel\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * Client constructor.
     *
     * @param \ByteDanceLaravel\Kernel\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        parent::__construct();

        $this->app = $app;

    }

    /**
     * Client constructor.
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
     * Undocumented function
     *
     * @param string $url
     * @param array $data
     * @return mixed
     */
    public function httpPostJson(string $url, array $query = [], array $json = [])
    {
        return $this->request($url, 'POST', ['json' => $json]);
    }

    /**
     * 解析跳转链接响应数据
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

    public function httpPostUpload($url, array $query, string $video_path)
    {
        $options = [
            'query' => $query,
            'multipart' => [
                [
                    'name' => 'video',
                    'contents' => fopen($video_path, 'r'),
                    'headers' => [
                        'Content-Type' => 'video/mp4',
                    ],
                ],
            ],
        ];

        return $this->request($url, 'POST', $options);
    }

}
