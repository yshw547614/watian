<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/28 0028
 * Time: 下午 2:44
 */

namespace app\admin\controller;


use app\admin\model\Order;
use app\admin\validate\BaseValidate;
use app\common\enum\OrderStatusEnum;
use app\common\service\Refund as RefundService;

class Refund extends BaseController
{
    public function index(){
        $orderModel = new Order();
        $condition = ['status'=>OrderStatusEnum::CANCEL,'is_pay'=>['neq',0]];
        $orders = $orderModel->where($condition)->order('create_time desc')->paginate(10);
        $empty = getEmpty(10);
        $page = $orders->render();
        return $this->fetch('index',['list'=>$orders,'page'=>$page,'empty'=>$empty]);
    }

    public function detail($id=-1){
        $data = Order::getDetail($id);
        $user = model('User')->where('id',$data['user_id'])->field('id,nickname,head_img')->find();
        if(!$user){
            $this->error('异常订单');
        }
        $data['user'] = $user;
        $data['pay_status'] = $data->getData('is_pay');
        return $this->fetch('detail',['data'=>$data]);
    }

    public function refund(){
        $data = input('post.');
        $rule = [
            'id' => 'require|isPositiveInteger',
            'is_pay' => 'require|in:2,3',
        ];
        $validate = new BaseValidate($rule);
        $validate->checkData($data);
        $order = Order::get($data['id']);
        if(!$order){
            $this->error('错误订单id');
        }
        if($data['is_pay'] == 2){
            $refundParame = $this->getRefundParame($order);
            RefundService::refund($refundParame);
        }
        $order->is_pay = $data['is_pay'];
        if($order->save()){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }

    public function getRefundParame($order){
        $total_fee = $order['order_price']*100;
        $refundParame = [
            'out_trade_no' => $order['order_no'],
            'transaction_id' => $order['transaction_id'],
            'out_refund_no' => md5(uniqid()),
            'total_fee' => $total_fee,
            'refund_fee' => $total_fee
        ];
        return $refundParame;
    }
}