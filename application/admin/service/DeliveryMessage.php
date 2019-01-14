<?php
/**


 
 * Date: 2017/3/7
 * Time: 13:27
 */

namespace app\admin\service;

use app\admin\model\Order;
use app\admin\model\User;
use app\common\service\WxMessage;
use think\Exception;

class DeliveryMessage extends WxMessage
{
    const DELIVERY_MSG_ID = 'tMKvBu8d9cXnppnucVpCR0coCapprSDa1UcR8SVhW58';// 小程序模板消息ID号

    //    private $productName;
    //    private $devliveryTime;
    //    private $order

    public function sendDeliveryMessage($orderId, $tplJumpPage = '')
    {
        $order = Order::get($orderId);
        $this->tplID = self::DELIVERY_MSG_ID;
        $this->formID = $order->prepay_id;
        $this->page = $tplJumpPage;
        $this->prepareMessageData($order);
        //$this->emphasisKeyWord='keyword2.DATA';
        return parent::sendMessage($this->getUserOpenID($order->user_id));
    }

    private function prepareMessageData($order)
    {
        $express = model('Express')->get($order->express_id);
        $data = [
            'keyword1' => [
                'value' => $order->order_no,
            ],
            'keyword2' => [
                'value' => $express->title
            ],
            'keyword3' => [
                'value' => $order->odd_number
            ],
            'keyword4' => [
                'value' => $order->snap_address->name
            ],
            'keyword5' => [
                'value' => $order->snap_address->mobile
            ],
            'keyword6' => [
                'value' => $order->snap_address->province.$order->snap_address->city.$order->snap_address->country.$order->snap_address->detail
            ],
            'keyword7' => [
                'value' => $order->action_note
            ]
        ];
        $this->data = $data;
    }

    private function getUserOpenID($uid)
    {
        $user = User::get($uid);
        if (!$user) {
            throw new \Exception();
        }
        return $user->openid;
    }
}