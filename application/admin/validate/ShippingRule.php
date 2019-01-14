<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/4
 * Time: 23:29
 */

namespace app\admin\validate;


class ShippingRule extends BaseValidate
{
    protected $rule = [
        'title' => 'require|max:100',
        'number' => 'require|array',
    ];
}