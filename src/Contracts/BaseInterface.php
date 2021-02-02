<?php
namespace Codeinfo\Bytedance\Contracts;

interface BaseInterface
{
    /**
     * 生成用户授权地址
     *
     * @param string $scope
     * @param string $redirect_uri
     * @return string
     */
    public function genrateUrl($scope, $redirect_uri);

    /**
     * 生成用户静默授权地址
     *
     * @param string $redirect_uri
     * @return string
     */
    public function genrateBaseUrl($redirect_uri);

    /**
     * 获取用户授权
     *
     * @param string $code
     * @return mixed
     */
    public function getOauthToken($code);

    /**
     * 获取用户信息
     *
     * @param string $open_id
     * @param string $access_token
     * @return mixed
     */
    public function userinfo($open_id, $access_token);

    /**
     * 解密手机号
     *
     * @param string $string
     * @return string
     */
    public function decrypt($string);

    /**
     * 上传视频
     *
     * @param array $query
     * @param string $video_path
     * @return mixed
     */
    public function videoUpload($query, $video_path);

    /**
     * 创建视频
     *
     * @param array $query
     * @param array $form_params
     * @return mixed
     */
    public function videoCreate($query, $form_params);

    public function videoComment($query, $form_params);

    /**
     * 根据主页解析用户ID
     *
     * @param string $url
     * @return mixed
     */
    public function getDouyinUid($url);

    public function getAccessToken();

    /**
     * 查询视频信息
     *
     * @param array $query
     * @return mixed
     */
    public function queryVideoData($query, $form_params);

    // /**
    //  * 获取票据
    //  *
    //  * @param [type] $token
    //  * @return void
    //  */
    // public function getTicket($token);

    // /**
    //  * 签名接口
    //  *
    //  * @param [type] $jsb_ticket
    //  * @param [type] $url
    //  * @param [type] $nonce_str
    //  * @param [type] $timestamp
    //  * @return mixed
    //  */
    // public function signature($jsb_ticket, $url, $nonce_str, $timestamp);
}
