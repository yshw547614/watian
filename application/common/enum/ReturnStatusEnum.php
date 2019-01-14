<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/8
 * Time: 17:01
 */

namespace app\common\enum;


class ReturnStatusEnum
{
    const REFUSE = -2;

    const CANCEL = -1;

    const SUBMIT = 0;

    const  THROUGH = 1;

    const DELIVERY = 2;

    const RECEIVE = 3;

    const FINISH = 4;

    public static function getReturnStatus(){
        $status = [
            self::REFUSE => '已拒绝',
            self::CANCEL => '已取消',
            self::SUBMIT => '提交审核',
            self::THROUGH => '审核通过',
            self::DELIVERY => '商品寄回',
            self::RECEIVE => '商品入库',
            self::FINISH => '退款完成',

        ];
        return $status;
    }
}