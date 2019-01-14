<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/9 0009
 * Time: 下午 5:46
 */

namespace app\admin\validate;

class Menu extends BaseValidate
{
    protected $rule = [
        'name' => 'require|max:40',
        'route' => 'require|max:100',

    ];
}