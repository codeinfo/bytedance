<?php

/**
 * This file is part of the codeinfo/ByteDanceLaravel.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ByteDanceLaravel\Platform\Video;

use ByteDanceLaravel\Kernel\Client;

class Video extends Client
{
    protected $baseUri = 'https://open.douyin.com';

    /**
     * 上传视频.
     *
     * @param string $query
     * @param string $video_path
     * @return mixed
     */
    public function upload(array $query, string $video_path)
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

        $endpoint = '/video/upload/';

        $response = $this->httpPost($this->baseUri.$endpoint, $options);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 创建视频.
     *
     * @param [type] $query
     * @param [type] $form_params
     * @return array
     */
    public function videoCreate(array $query, array $form_params)
    {
        $endpoint = '/video/create/';

        $options = [
            'query' => $query,
            'json' => $form_params,
        ];
    }

    /**
     * 评论视频.
     *
     * @param array $query
     * @param string $form_params
     * @return array
     */
    public function videoComment(array $query, string $form_params)
    {
        $endpoint = '/item/comment/reply/';

        $options = [
            'query' => $query,
            'json' => $form_params,
        ];

        $response = $this->httpPost($this->baseUri.$endpoint, $options);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 查询视频信息.
     *
     * @param array $query
     * @return json
     */
    public function queryVideoData(array $query, string $form_params)
    {
        $endpoint = '/video/data/';

        $options = [
            'query' => $query,
            'json' => $form_params,
        ];

        $response = $this->httpPost($this->baseUri.$endpoint, $options);

        return json_decode($response->getBody()->getContents(), true);
    }
}
