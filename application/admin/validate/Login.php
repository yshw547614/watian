<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 下午 3:34
 */

namespace app\admin\validate;


class Login extends BaseValidate
{
    protected $rule = [
        'name|用户名' => 'require',
        'password|密码' => 'require',
        'code|验证码' => 'require|captcha',

    ];
}