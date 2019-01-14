<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/25 0025
 * Time: 下午 2:49
 */

namespace app\admin\validate;

class IdMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
}