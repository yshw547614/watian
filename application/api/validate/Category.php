<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/2 0002
 * Time: 下午 2:56
 */

namespace app\api\validate;


class Category extends BaseValidate
{
    protected $rule = [
        'size' => 'isPositiveInteger',
    ];
}