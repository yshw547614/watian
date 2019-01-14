<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/27 0027
 * Time: 下午 2:48
 */

namespace app\admin\validate;

class AuthGroup extends BaseValidate
{
    protected $rule = [
        'title|用户组名称' => 'require|max:30',
        'status|用户组状态' => 'require|integer',
        'rules|用户组权限' => 'require|array',
    ];
    protected $message = [
        'title.max' => '用户组名称最大长度30',
        'rules.array' =>'用户组权限必须是数组',
    ];
}