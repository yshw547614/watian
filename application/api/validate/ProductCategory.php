<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/24 0024
 * Time: 下午 4:21
 */

namespace app\api\validate;


class ProductCategory extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
        'page' => 'isPositiveInteger',
        'size' => 'isPositiveInteger',
        'rank' => 'in:1,2,3,4,5'
    ];
    protected $message = [
        'rank.in' => 'rank参数无效'
    ];
}