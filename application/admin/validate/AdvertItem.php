<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/6 0006
 * Time: 下午 2:56
 */

namespace app\admin\validate;


class AdvertItem extends BaseValidate
{
    protected $rule = [
        'link|跳转地址' => 'require|isNotEmpty',
    ];
}