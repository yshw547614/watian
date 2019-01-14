<?php
/**

 * Date: 2017/2/26
 * Time: 16:02
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\common\enum\OrderStatusEnum;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');


class Pay
{
    private $orderID;

    function __construct($orderID)
    {
        $this->orderID = $orderID;
    }

    public function pay()
    {
        $param = $this->checkOrderValid();
        return $this->makeWxPreOrder($param);
    }

    // 构建微信支付订单信息
    private function makeWxPreOrder($param)
    {
		$openid = Token::getCurrentTokenVar('openid');
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($param['out_trade_no']);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($param['total_fee'] * 100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetAttach($param['attach']);
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('wx.pay_back_url'));
        return $this->getPaySignature($wxOrderData);
    }

    //向微信请求订单号并生成签名
    private function getPaySignature($wxOrderData)
    {
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        // 失败时不会返回result_code
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);
        return $signature;
    }

    private function recordPreOrder($wxOrder){
        // 必须是update，每次用户取消支付后再次对同一订单支付，prepay_id是不同的
        OrderModel::where('id', 'in', $this->orderID)->update(['prepay_id' => $wxOrder['prepay_id']]);
    }

    // 签名
    private function sign($wxOrder)
    {
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0, 1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id=' . $wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['appId']);
        return $rawValues;
    }


    private function checkOrderValid()
    {
        $result =[
            'total_fee' =>0,
            'out_trade_no' => '',
            'attach' => ''
        ];
        $uid = Token::getCurrentUid();
        $orders = model('Order')->where('id', 'in', $this->orderID)
            ->where('user_id',$uid)->order('id desc')->select();
        if(!$orders){
            throw new Exception('订单不存在，请检查ID',404);
        }
        $orderNums = count($orders);
        for($i=0;$i<$orderNums;$i++){
            if($orders[$i]['status'] != OrderStatusEnum::UNPAID){
                throw new Exception('订单已支付过啦',404);
            }
            $result['total_fee'] += $orders[$i]['order_price'];
            $result['attach'] .= ($i == $orderNums-1)?$orders[$i]['order_no']:$orders[$i]['order_no']."#";
        }
        $result['out_trade_no'] = Order::makeOrderNo();
        return $result;
    }
}