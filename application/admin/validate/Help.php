<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/13 0013
 * Time: 上午 9:55
 */

namespace app\admin\validate;

class Help extends BaseValidate
{
    protected $rule = [
        'title|文档标题' => 'require|length:1,60',
        'recommend' => 'require|in:0,1',
        'type_id' => 'require|isPositiveInteger'
    ];
}