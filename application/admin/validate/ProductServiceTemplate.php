<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/17
 * Time: 23:06
 */

namespace app\admin\validate;


class ProductServiceTemplate extends BaseValidate
{
    protected $rule = [
        'name|模板名称' => 'require|max:30|isNotEmpty|unique:product_service_template',
        'service|售后服务项' => 'require|array'
    ];
}