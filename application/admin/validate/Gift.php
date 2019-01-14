<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/11 0011
 * Time: 下午 3:22
 */

namespace app\admin\validate;

class Gift extends BaseValidate
{
    protected $rule = [
        'name' => 'require|max:20|isNotEmpty',
        'type' => 'require|isPositiveInteger',
        'price' => 'require|isPositiveInteger',
    ];
}