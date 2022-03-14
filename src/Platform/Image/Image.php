<?php

namespace Codeinfo\LaravelBytedance\Platform\Image;

use Codeinfo\LaravelBytedance\Kernel\Client;

class Image extends Client
{

  protected $baseUri = 'https://open.douyin.com';

  
  public function upload(string $open_id, string $access_token, string $image_path)
    {
        $response = $this->httpPostUpload('/image/upload/', [
            'open_id' => $open_id,
            'access_token' => $access_token,
        ], $image_path);

        return json_decode($response->getBody()->getContents(), true);
    }
}
