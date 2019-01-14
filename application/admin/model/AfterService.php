<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/7
 * Time: 17:01
 */

namespace app\admin\model;

use app\common\enum\OrderStatusEnum;
use app\common\enum\ReturnStatusEnum;
use app\common\model\AfterService as AfterServiceCommon;
class AfterService extends BaseModel
{
    protected $hidden = ['update_time'];

    use AfterServiceCommon;
    public function getRefundAttr($value,$data){
        $status = ReturnStatusEnum::getReturnStatus();
        $result = $status[$data['status']];
        if(isset($result)){
            return $result;
        }
    }
    public function getTypeAttr($value){
        $status = [
            '仅退款',
            '退货退款',
            '换货'
        ];
        if(isset($status[$value])){
            return $status[$value];
        }
    }
    public function getProductStatusAttr($value){
        $status = [
            '未收到货',
            '已收到货',
        ];
        if(isset($status[$value])){
            return $status[$value];
        }
    }

    public function user(){
        return $this->belongsTo('User','user_id','id');
    }
    public static function getOrderStatusByAfterService($order_product_id){
        $result = [];
        $orderId = model('OrderProduct')->where('id',$order_product_id)->value('order_id');
        $orderProductIds = model('OrderProduct')->where('order_id',$orderId)->column('id');
        $orderProductNum = count($orderProductIds);
        $agreeNum  = self::where('order_product_id','in',$orderProductIds)->where('status',2)->count();
        $result['order_id'] = $orderId;
        if($agreeNum == $orderProductNum){
            $result['status'] = OrderStatusEnum::REFUND;
        }
        return $result;
    }
}