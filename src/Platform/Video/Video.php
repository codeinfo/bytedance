<?php

/**
 * This file is part of the Codeinfo\LaravelBytedance.
 *
 * (c) codeinfo <nanye@codeinfo.cn>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Codeinfo\LaravelBytedance\Platform\Video;

use Codeinfo\LaravelBytedance\Kernel\Client;

class Video extends Client
{
    protected $baseUri = 'https://open.douyin.com';

    /**
     * Upload Video.
     *
     * @param string $open_id
     * @param string $access_token
     * @param string $video_path
     * @return array
     */
    public function upload(string $open_id, string $access_token, string $video_path)
    {
        $response = $this->httpPostUpload('/video/upload/', [
            'open_id' => $open_id,
            'access_token' => $access_token,
        ], 'video',$video_path);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Video Create.
     *
     * @param string $open_id
     * @param string $access_token
     * @param array $form_params
     * @return array
     */
    public function create(string $open_id, string $access_token, array $form_params)
    {
        $response = $this->httpPostJson('/video/create/', [
            'open_id' => $open_id,
            'access_token' => $access_token,
        ], $form_params);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Video Comment.
     *
     * @param string $open_id
     * @param string $access_token
     * @param string $content
     * @param string $item_id
     * @param string $comment_id
     * @return array
     */
    public function comment(
        string $open_id,
        string $access_token,
        string $content,
        string $item_id,
        string $comment_id = ''
    ) {
        $form_params = [
            'item_id' => $item_id,
            'content' => $content,
        ];

        if (! empty($comment_id)) { // 需要回复的评论id（如果需要回复的是视频不传此字段）
            array_merge($form_params, [
                'comment_id' => $comment_id,
            ]);
        }

        $response = $this->httpPostJson('/item/comment/reply/', [
            'open_id' => $open_id,
            'access_token' => $access_token,
        ], $form_params);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Query Video Information.
     *
     * @param string $open_id
     * @param string $access_token
     * @param array $item_ids
     * @return array
     */
    public function data(string $open_id, string $access_token, array $item_ids)
    {
        $response = $this->httpPostJson('/video/data/', [
            'open_id' => $open_id,
            'access_token' => $access_token,
        ], [
            'item_ids' => $item_ids,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
