<?php
/**

 * Date: 2017/2/22
 * Time: 21:52
 */

namespace app\api\controller;

use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\api\service\Token;
use app\api\validate\BaseValidate;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\validate\PagingParameter;
use app\common\enum\OrderStatusEnum;
use app\common\response\RequestResponse;
use think\Exception;

class Order extends BaseController
{

    /**
     * 下单
     * @url /order
     * @HTTP POST
     */
    public function placeOrder()
    {
        $validate = new OrderPlace();
        $validate->checkUp();
        $order = new OrderService();
        $data = $order->splitOrder();
        return RequestResponse::getResponse('','','',$data);
    }

    public function calculateOrderPrice(){
        $validate = new OrderPlace();
        $validate->checkUp();
        $order = new OrderService();
        $result = $order->calculateOrderPrice();
        return $result;
    }


    public function getDetail($id)
    {
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $exField = [
            'id',
            'total_price',
            'total_count',
            'transaction_id',
            'prepay_id',
            'identify_card_id',
            'shipping_time',
            'pay_time',
            'action_note',
            'total_fee'
        ];
        $order = model('Order')->field($exField,true)->where('id',$id)->find();
        if(!$order){
            throw new Exception('订单Id错误',400);
        }
        $express = [];
        if($order['is_delivery'] == 1){
            $expressRow = model('Express')->get($order['express_id']);
            $express['odd_number'] = $order['odd_number'];
            if($expressRow){
                $express['name'] = $expressRow['title'];
                $express['code'] = $expressRow['code'];
                $express['type'] = $expressRow['type'];
            }
        }
        $order['express'] =$express;
        $orderProducts = model('OrderProduct')->with(
            [
                'product' => function($query){
                    $query->field('id,is_on_sale');
                }
            ]
        )->field('id order_product_id')->field('id,user_id,evaluate',true)
            ->where('order_id',$id)->select();
        if(!$orderProducts){
            throw new Exception('异常订单',506);
        }
        foreach ($orderProducts as &$orderProduct){
            $orderProduct['is_on_sale'] = $orderProduct['product']['is_on_sale'];
            unset($orderProduct['product']);
        }
        $order['snap_items'] = $orderProducts;
        $sevice = new OrderService();
        $isAllowReturn = $sevice->getOrderIsAllowReturn($order['status'],$order['confirm_time'],$id);
        $order['is_allow_return'] = $isAllowReturn;
        $order->hidden(['express_id','odd_number','confirm_time']);
        return RequestResponse::getResponse('','','',$order);

    }

    /**
     * 获取用户订单列表（分页）
     * @param int $page
     * @param int $size
     * @return array
     * @throws \app\api\exception\ParameterException
     */
    public function getSummaryByUser($page = 1,$size = 20,$type='all')
    {
        $uid = Token::getCurrentTokenVar('uid');
        $validate = new PagingParameter();
        $validate->checkUp();
        $rule = [
            'type' => 'in:all,will_paid,will_delivery,will_receive'
        ];
        $msg = [
            'type.in' => 'type参数有误'
        ];
        $validateType = new BaseValidate($rule,$msg);
        if(!$validateType->check(['type'=>$type])){
            return RequestResponse::getResponse($validateType->getError(),'error',400);
        }
        $data = OrderModel::getSummaryByUser($uid, $page, $size,$type);
        return RequestResponse::getResponse('','','',$data);
    }

    /**
     * 获取全部订单简要信息（分页）
     * @param int $page
     * @param int $size
     * @return array
     */
    public function getSummary($page=1, $size = 20){
        $validate = new PagingParameter();
        $validate->checkUp();
        $pagingOrders = OrderModel::getSummaryByPage($page, $size);
        if ($pagingOrders->isEmpty())
        {
            return [
                'current_page' => $pagingOrders->currentPage(),
                'data' => []
            ];
        }
        $data = $pagingOrders->hidden(['snap_items', 'snap_address'])->toArray();
        return [
            'current_page' => $pagingOrders->currentPage(),
            'data' => $data
        ];
    }

    public function cancelOrder($id=-1){
        $uid = Token::getCurrentUid();
        $orderModel = new OrderModel();
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $order = $orderModel->where(['id'=>$id,'user_id'=>$uid])->find();
        if(!$order){
            return RequestResponse::getResponse('错误id参数','error',403);
        }
        if($order->status == OrderStatusEnum::UNPAID){
            $order->status = OrderStatusEnum::CANCEL;
            $order->save();
            return RequestResponse::getResponse();
        }else if($order->status == OrderStatusEnum::PAID){
            $service = new OrderService();
            $result = $service->refund($order);
            if($result['return_code'] == 'SUCCESS'){
                $order->status = OrderStatusEnum::REFUND;
                $order->save();
                return RequestResponse::getResponse();
            }else{
                return RequestResponse::getResponse($result['return_msg'],'error','502');
            }

        }else{
            return RequestResponse::getResponse('异常订单','error',408);
        }
    }

    public function deleteOrder($id=-1){
        $uid = Token::getCurrentUid();
        $orderModel = new OrderModel();
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $order = $orderModel->where(['id'=>$id,'user_id'=>$uid])->find();
        if(!$order){
            return RequestResponse::getResponse('错误订单Id','error',400);
        }
        return OrderModel::deleteOrder($id);
    }

    public function calculateRealPrice(){
        $id = input('post.id/a');
        $rule = [
            'id' => 'require|array'
        ];
        $msg = [
            'id.require' => '参数不正确',
            'id.array' => '参数不正确',
        ];
        $data = [
            'real_price' => 0,
            'pay_name' => '微信支付',
        ];
        $validate = new BaseValidate($rule,$msg);
        $validate->checkUp();
        $data['real_price'] = model('Order')->where('id','in',$id)->sum('order_price');
        return RequestResponse::getResponse('','','',$data);
    }
}