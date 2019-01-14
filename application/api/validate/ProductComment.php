<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/23 0023
 * Time: 下午 6:10
 */

namespace app\api\validate;


class ProductComment extends BaseValidate
{
    protected $rule = [
        'order_product_id' => 'require|isPositiveInteger',
        'content|评论内容' => 'require|max:255',
        'images|评论图片' => 'array',
        'evaluate' => 'require|isPositiveInteger',
        'star|满意度' => 'require|isPositiveInteger',
    ];
}