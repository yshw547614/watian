<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/7 0007
 * Time: 下午 5:09
 */

namespace app\admin\validate;


class Admin extends BaseValidate
{
    protected $rule = [
        'name|用户名' => 'require|length:5,20|alphaDash|unique:admin',
        'password|密码' => 'require|length:6,12|alphaDash',
        'groups|用户组' => 'require|array'
    ];
    protected $scene = [
        'add' => ['name','password','groups'],
        'edit' => [
            'name',
            'password' => 'length:6,12|alphaDash',
            'groups'
        ],
    ];
}