<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/30 0030
 * Time: 下午 2:28
 */

namespace app\admin\validate;

class TagsType extends BaseValidate
{
    protected $rule = [
        'title|分类名称' => 'require|unique:tags_type|max:30',
    ];
}