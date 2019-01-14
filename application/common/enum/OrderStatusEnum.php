<?php
/**


 
 * Date: 2017/3/7
 * Time: 16:10
 */

namespace app\common\enum;


class OrderStatusEnum
{
    //已退款
    const REFUND = -2;

    //已取消
    const CANCEL = -1;

    // 未支付（待支付）
    const UNPAID = 0;

    // 已支付(待发货)
    const PAID = 1;

    // 已发货(待收货)
    const DELIVERED = 2;

    // 已收货(交易完成)
    const RECEIVE = 3;

    //已作废
    const INVALID = 4;

    public static function getOrderStatus(){
        $status = [
            self::UNPAID => '待支付',
            self::PAID => '待发货',
            self::DELIVERED => '待收货',
            self::RECEIVE => '交易完成',
            self::CANCEL => '已取消',
            self::REFUND => '已退款',
        ];
        return $status;
    }

}