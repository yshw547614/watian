<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/5 0005
 * Time: 上午 11:38
 */

namespace app\api\validate;


class GetComments extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
        'type' => 'in:0,1,2,3,4,5',
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger'
    ];
}