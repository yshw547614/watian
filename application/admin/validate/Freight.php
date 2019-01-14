<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/14 0014
 * Time: 上午 9:20
 */

namespace app\admin\validate;


class Freight extends BaseValidate
{
    protected $rule = [
        'name' => 'require|max:100',
        'type' => 'require|in:0,1,2',
        'is_enable_default' => 'require|in:0,1',
        'first_unit' => 'require|array',
        'first_money' => 'require|array',
        'continue_unit' => 'require|array',
        'continue_money' => 'require|array',
    ];
}