<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/5 0005
 * Time: 下午 8:07
 */

namespace app\common\service;
use think\Loader;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Refund
{
    public static function refund($refundParame){

        $wxPayConfig = new \WxPayConfig();
        $merchid = $wxPayConfig::MCHID;
        $refund = new \WxPayRefund();
        $refund->SetTransaction_id($refundParame['transaction_id']);  	//微信官方生成的订单流水号，在支付成功中有返回
        $refund->SetOut_refund_no($refundParame['out_refund_no']);			//退款单号
        $refund->SetTotal_fee($refundParame['total_fee']);			//订单标价金额，单位为分
        $refund->SetRefund_fee($refundParame['refund_fee']);			//退款总金额，订单总金额，单位为分，只能为整数
        $refund->SetOp_user_id($merchid);
        $wxPayApi = new \WxPayApi();
        $result = $wxPayApi::refund($refund);
        return $result;
    }
}