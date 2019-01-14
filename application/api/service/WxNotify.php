<?php
/**


 
 * Date: 2017/2/28
 * Time: 18:12
 */

namespace app\api\service;

use app\common\enum\OrderStatusEnum;
use think\Loader;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        if ($data['result_code'] == 'SUCCESS') {
            $attach = $data['attach'];
            $orderNoArr = explode('#',$attach);
            $field = ['id','status','is_pay','transaction_id','pay_time','total_fee'];
            $orders = model('Order')->field($field)->where('order_no', 'in', $orderNoArr)
                ->where('status',OrderStatusEnum::UNPAID)->lock(true)->select();
            $result = '';
            if($orders){
                $orders = $orders->toArray();
                foreach ($orders as &$order){
                    $order['status'] = OrderStatusEnum::PAID;
                    $order['is_pay'] =1;
                    $order['transaction_id'] = $data['transaction_id'];
                    $order['pay_time'] = time();
                    $order['total_fee'] = $data['total_fee'];
                }
                $result = model('Order')->saveAll($orders);
            }
            if($result){
                $str = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
            }else{
                $str = '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[ERROR]]></return_msg></xml>';
            }

            return $str;
        }
    }

}