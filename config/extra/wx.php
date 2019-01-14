<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/12 0012
 * Time: 上午 10:32
 */
return [
    //  +---------------------------------
    //  微信相关配置
    //  +---------------------------------

    // 小程序app_id
    'app_id' => 'wx39162f1a8f206c31',
    // 小程序app_secret
    'app_secret' => '06345b82bb2014fa0250c697c9eb765e',

    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",

    'pay_back_url' => 'https://4g.muyuxinling.com/api/pay/notify',
];