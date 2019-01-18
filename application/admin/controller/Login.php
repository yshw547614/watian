<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 上午 11:27
 */

namespace app\admin\controller;

use app\common\response\RequestResponse;
use think\captcha\Captcha;
use app\admin\validate\Login as LoginValidate;
use app\admin\service\Login AS LoginService;


class Login extends BaseController
{
    public function login(){
        return $this->fetch();
    }
    public function handle(){
        $data = input('post.');
        $validate = new LoginValidate();
        $validate->checkout();
        $loginService = new LoginService();
        $status = $loginService->login($data);
        if($status){
            return RequestResponse::getResponse();
        }else{
            return RequestResponse::getResponse('用户名或者密码错误','error',403);
        }

    }
    public function logout(){
        session(null);
        return RequestResponse::getResponse();
    }
    public function verify(){
        $config = [
            'fontSize' => 14,
            'length' => 4,
            'imageW' => 100,
            'imageH' =>36,
            'useNoise'    =>    false,
            'useCurve' => false,
        ];
        $captcha = new Captcha($config);
        $captcha->codeSet = '0123456789';
        return $captcha->entry();
    }
}