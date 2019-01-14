<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/22 0022
 * Time: 下午 3:44
 */

namespace app\api\validate;


class Certificate extends BaseValidate
{
    protected $rule = [
        'title|证书名称' => 'require|isNotEmpty|max:50',
        'images|证书图片' => 'require|array'
    ];
}