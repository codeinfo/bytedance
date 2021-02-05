# 字节跳动扩展包
[![StyleCI](https://github.styleci.io/repos/335143363/shield?branch=main)](https://github.styleci.io/repos/335143363?branch=main)
### 使用方法

        use ByteDanceLaravel\Factory;

        $app = Factory::platform(config('bytedance.platform'))

### Platform for Oauth

* getAccessToken

        $app->oauth->getAccessToken($code);

* genrateUrl

        $scope = 'user_info,video.create,item.comment,video.data';
        $app->oauth->genrateUrl($scope, $redirect_uri);

* genrateBaseUrl

    静默授权地址 , 未使用

### Platform for Account

* decryptMobile

        $app->account->decryptMobile($string);

* userInfo

        $app->account->userInfo($open_id, $access_token);

### Platform for Account


