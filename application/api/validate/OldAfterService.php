<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/5 0005
 * Time: 上午 10:18
 */

namespace app\api\validate;


class AfterService extends BaseValidate
{
    protected $rule = [
        'order_product_id' => 'require|isPositiveInteger',
        'type|服务类型' => 'in:1,2',
        'product_status|货物状态' => 'require|in:1,2',
        'reason|退款原因' => 'require|isPositiveInteger',
        'money|退款金额' => 'require|number',
        'remark|退款说明' => 'max:255'
    ];
}