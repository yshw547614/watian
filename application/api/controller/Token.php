<?php

namespace app\api\controller;


use app\api\service\AppToken;
use app\api\service\UserToken;
use app\api\service\Token as TokenService;
use app\api\validate\AppTokenGet;
use app\api\validate\TokenGet;
use app\common\response\RequestResponse;

/**
 * 获取令牌，相当于登录
 */
class Token
{
    /**
     * 用户获取令牌（登陆）
     * @url /token
     * @POST code
     * @note 虽然查询应该使用get，但为了稍微增强安全性，所以使用POST
     */
    public function getToken($code='')
    {
        $validate = new TokenGet();
        $validate->checkUp();
        $wx = new UserToken($code);
        $result = $wx->get();
        return $result;
    }

    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
    public function getAppToken($ac='', $se='')
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET');
        (new AppTokenGet())->checkUp();
        $app = new AppToken();
        $token = $app->get($ac, $se);
        return ['token' => $token];
    }

    public function verifyToken($token='')
    {
        if(!$token){
            return RequestResponse::getResponse('token不允许为空','error',400);
        }
        $valid = TokenService::verifyToken($token);
        if($valid){
            return RequestResponse::getResponse();
        }else{
            return RequestResponse::getResponse('无效的code参数','error',400);
        }
    }

}