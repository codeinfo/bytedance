# 字节跳动扩展包
[![StyleCI](https://github.styleci.io/repos/335143363/shield?branch=main)](https://github.styleci.io/repos/335143363?branch=main)

## 初始化

        composer require codeinfo/bytedance-for-laravel

## 使用方法

        use Codeinfo\ByteDanceLaravel\Factory;

        $app = Factory::platform(config('bytedance.platform'));

### Platform for Oauth 账号授权

* getAccessToken

        $app->oauth->getAccessToken($code);

* genrateUrl

        $scope = 'user_info,video.create,item.comment,video.data';
        $app->oauth->genrateUrl($scope, $redirect_uri);
### Platform for Account 用户管理

        $app->account

* 解密手机号

        decryptMobile($string);

* 获取用户信息

        userInfo($open_id, $access_token);

### Platform for Video 视频管理

        $app->video

* 上传视频

        upload(string $open_id, string $access_token, string $video_path)

* 创建视频

        create(string $open_id, string $access_token, array $form_params)

* 视频评论

        comment(string $open_id, string $access_token, string $content, string $item_id, string $comment_id = '')

* 查询视频信息

        data(string $open_id, string $access_token, array $item_ids)

## Microapp

        $app = Factory::microapp(config('bytedance.microapp'));
