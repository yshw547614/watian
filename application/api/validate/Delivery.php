<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/14 0014
 * Time: 上午 11:56
 */

namespace app\api\validate;


class Delivery extends BaseValidate
{
    protected $rule = [
        'express_id' => 'require|isPositiveInteger',
        'service_id' => 'require|isPositiveInteger',
        'odd_number' => 'require|isNotEmpty'
    ];

    protected $message = [
        'express_id.require' => '请正确选择快递公司',
        'express_id.isPositiveInteger' => '请正确选择快递公司',
        'odd_number.require' => '请正确填写快递单号',
        'odd_number.isNotEmpty' => '请正确填写快递单号',
        'service_id.require' => '参数不正确',
        'service_id.isPositiveInteger' => '参数不正确',
    ];

}