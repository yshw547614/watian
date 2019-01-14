<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/25 0025
 * Time: 下午 2:37
 */

namespace app\admin\validate;

class AuthRule extends BaseValidate
{
    protected $rule =[
        'pid' => 'require|integer',
        'title|权限名' => 'require',
        'name' => 'require',
    ];
    protected $message = [
        'title.require' => '权限名不能为空',
        'name.require' => '权限值不能为空',
    ];
}