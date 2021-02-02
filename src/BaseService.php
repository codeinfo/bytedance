<?php
namespace Codeinfo\Bytedance;

use Codeinfo\Bytedance\Contracts\BaseInterface;
use Codeinfo\Bytedance\Exceptions\ResponseExcetion;
use Codeinfo\Bytedance\Traits\Platform\Oauth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BaseService implements BaseInterface
{
    use Oauth;

    /**
     * @var string
     */
    protected $client_key;

    /**
     * @var string
     */
    protected $client_secret;

    /**
     * @var string
     */
    protected $cachePrefix = 'bytedance.';

    /**
     * @var string
     */
    protected $client_token;

    /**
     * @var string
     */
    protected $jsb_ticket;

    public function __construct($config)
    {
        $this->init($config);
    }

    /**
     * 初始化配置
     *
     */
    public function init($config)
    {
        $this->client_key = $config['client_key'];
        $this->client_secret = $config['client_secret'];
    }

    /**
     * 生成用户授权地址
     *
     * @param string $scope
     * @param string $redirect_uri
     * @return string
     */
    public function genrateUrl($scope, $redirect_uri)
    {
        $query = [
            'client_key' => $this->client_key,
            'response_type' => 'response_type',
            'scope' => $scope,
            'redirect_uri' => $redirect_uri,
        ];

        $url = 'https://open.douyin.com/platform/oauth/connect/?';

        foreach ($query as $key => $value) {
            $url .= '&' . $key . '=' . $value;
        }

        return $url;
    }

    /**
     * 生成用户静默授权地址
     *
     * @param string $redirect_uri
     * @return string
     */
    public function genrateBaseUrl($redirect_uri, $state = null)
    {
        $query = [
            'client_key' => $this->client_key,
            'response_type' => 'code',
            'scope' => 'login_id',
            'state' => $state ?? '',
            'redirect_uri' => $redirect_uri,
        ];

        $url = 'https://aweme.snssdk.com/oauth/authorize/v2/?';

        foreach ($query as $key => $value) {
            $url .= '&' . $key . '=' . $value;
        }

        return $url;
    }

    /**
     * 解密手机号
     *
     * @param string $string
     * @return string
     */
    public function decrypt($string)
    {
        $key = $this->client_secret;
        $iv = substr($key, 0, 16);
        return openssl_decrypt(base64_decode($string), 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * 获取用户信息
     *
     * @param string $open_id
     * @param string $access_token
     * @return mixed
     */
    public function userinfo($open_id, $access_token)
    {
        $url = 'https://open.douyin.com/oauth/userinfo/';

        $query = [
            'access_token' => $access_token,
            'open_id' => $open_id,
        ];

        $options = [
            'query' => $query,
        ];

        try {
            $result = $this->curlGuzzleHttp($url, 'GET', $options);
        } catch (\Exception $e) {
            throw new ResponseExcetion('获取用户信息', 300003, $e);
        }

        return $result->data;
    }

    /**
     *  上传视频
     *
     * @param [type] $query
     * @return mixed
     */
    public function videoUpload($query, $video_path)
    {
        $url = 'https://open.douyin.com/video/upload/';

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

        try {
            $result = $this->curlGuzzleHttp($url, 'POST', $options);
        } catch (\Exception $e) {
            Log::error('videoUpload', [
                'message' => $e->getMessage(),
            ]);
            throw new ResponseExcetion('上传视频发生错误', 300006, $e);
        }

        return $result->data->video->video_id;
    }

    /**
     * 创建视频
     *
     * @param [type] $query
     * @param [type] $form_params
     * @return mixed
     */
    public function videoCreate($query, $form_params)
    {
        $url = 'https://open.douyin.com/video/create/';

        $options = [
            'query' => $query,
            'json' => $form_params,
        ];

        try {
            $result = $this->curlGuzzleHttp($url, 'POST', $options);
        } catch (\Exception $e) {
            throw new ResponseExcetion('发布视频', 300007, $e);
        }

        Log::info('videoCreate', [
            'form_params' => $form_params,
            'res' => $result,
        ]);

        return $result;
    }

    public function videoComment($query, $form_params)
    {
        $url = 'https://open.douyin.com/item/comment/reply/';

        $options = [
            'query' => $query,
            'json' => $form_params,
        ];
        try {
            $result = $this->curlGuzzleHttp($url, 'POST', $options);
        } catch (\Exception $e) {
            throw new ResponseExcetion('评论视频', 300008, $e);
        }

        return $result;
    }

    /**
     * 查询视频信息
     *
     * @param string $query
     * @return json
     */
    public function queryVideoData($query, $form_params)
    {
        $url = "https://open.douyin.com//video/data/";
        $options = [
            'query' => $query,
            'json' => $form_params,
        ];
        try {
            $result = $this->curlGuzzleHttp($url, 'POST', $options);
        } catch (\Exception $e) {
            throw new ResponseExcetion('评论视频', 300008, $e);
        }

        return $result;
    }

    /**
     * 获取 client_token
     *
     * @return void
     */
    public function getAccessToken()
    {
        return Cache::remember($this->cachePrefix . 'access_token', 7200, function () {
            $res = $this->curlAccessToken();
            return $res->data->access_token;
        });
    }

    /**
     * 请求获取 client_token
     *
     * @return mixed
     */
    private function curlAccessToken()
    {
        $url = 'https://open.douyin.com/oauth/client_token/';

        $query = [
            'client_key' => $this->client_key,
            'client_secret' => $this->client_secret,
            'grant_type' => 'client_credential',
        ];

        $options = [
            'query' => $query,
        ];

        try {
            $result = $this->curlGuzzleHttp($url, 'GET', $options);
        } catch (\Exception $e) {
            throw new ResponseExcetion('获取token失败', 300001, $e);
        }

        return $result;
    }

    // /**
    //  * 签名
    //  *
    //  * @param [type] $url
    //  * @param [type] $nonce_str
    //  * @param [type] $timestamp
    //  * @return void
    //  */
    // public function signature($jsb_ticket, $url, $nonce_str, $timestamp)
    // {
    //     $string = "jsapi_ticket=$jsb_ticket&nonce_str=$nonce_str&timestamp=$timestamp&url=$url";

    //     return md5($string);
    // }

    // /**
    //  * 获取签名票据
    //  *
    //  * @return mixed
    //  */
    // public function getTicket($token)
    // {
    //     return Cache::remember($this->cachePrefix . 'ticket', 7200, function () use ($token) {
    //         $url = 'https://open.douyin.com/js/getticket/';

    //         $query = [
    //             'access_token' => $token,
    //         ];

    //         $options = [
    //             'query' => $query,
    //         ];

    //         try {
    //             $result = $this->curlGuzzleHttp($url, 'GET', $options);
    //             Log::info('getTicket', [$result]);
    //         } catch (\Exception $e) {
    //             echo 'Exception when calling ToutiaoClientTokenApi->oauthClientTokenGet: ', $e->getMessage(), PHP_EOL;
    //         }

    //         return $result->data->ticket;
    //     });
    // }

    /**
     * 抖音主页解析
     *
     * @return void
     */
    public function getDouyinUid($url)
    {
        // // 转换为访问路径
        // $string = '在抖音，记录美好生活！ https://v.douyin.com/JCawLPt/';
        // $pattern = '/https:[\/]{2}[a-z]+[.]{1}[a-z\d\-]+[.]{1}[a-z\d]*[\/]*[A-Za-z\d]*[\/]*[A-Za-z\d]*/';
        // preg_match_all($pattern, $string, $arr);
        // $url = $arr[0][0];
        // 发起请求查询实际用户主页ID
        $options = [
            'allow_redirects' => [
                'track_redirects' => true,
            ],
        ];
        $response = self::getCurlResponse($url, 'GET', $options);
        $redrict_url = $response->getHeaderLine('X-Guzzle-Redirect-History');
        // 解析地址
        return explode('/', parse_url($redrict_url)['path'])[3];
    }

    /**
     * 获取远程地址跳转后URL参数
     *
     * @param [type] $url
     * @param string $method
     * @param array $options
     * @return mixed
     */
    private static function getCurlResponse($url, $method = 'GET', $options = [])
    {
        $client = new Client([
            // You can set any number of default request options.
            'timeout' => 20.0,
            'verify' => false,
        ]);

        $options = array_merge($options, [
            'debug' => false,
        ]);

        try {
            $response = $client->request($method, $url, $options);
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

        return $response;
    }

}
