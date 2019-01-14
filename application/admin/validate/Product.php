<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/3 0003
 * Time: 上午 11:48
 */

namespace app\admin\validate;

class Product extends BaseValidate
{
    protected $rule = [
        'name|商品名称' => 'require|isNotEmpty',
        'short_name|缩略名称' => 'require|isNotEmpty',
        'original_price|商品原价' => 'require|number',
        'price|商品优惠价格' => 'require|number',
        'stock|商品库存' => 'require|integer',
        'category_id|商品分类' =>'require|isPositiveInteger',
    ];

}