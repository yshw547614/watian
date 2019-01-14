<?php

/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/24 0024
 * Time: 上午 11:15
 */
namespace app\admin\command;

use app\admin\model\Order;
use app\admin\model\OrderProduct;
use app\admin\model\ProductComment;
use app\common\enum\OrderStatusEnum;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('test')->setDescription('Here is the remark ');
    }
    protected function execute(Input $input, Output $output)
    {
        $this->task();
    }
    private function task(){
        $this->setReceive();
        $this->setEvaluate();
    }
    private function setReceive(){
        $orderModel = new Order();
        $orderProductModel = new OrderProduct();
        $condition = [
            'is_pay' => 1,
            'status' => OrderStatusEnum::DELIVERED,
            'is_delivery' =>1
        ];
        $data = [
            'status' => OrderStatusEnum::RECEIVE,
            'confirm_time' => time(),
        ];
        $orderIds = $orderModel->where($condition)->whereTime('shipping_time','<','-15 days')->column('id');
        if($orderIds){
            $orderModel->where('id','in',$orderIds)->update($data);
            $orderProductModel->where('order_id','in',$orderIds)->where('evaluate',1)->update(['evaluate'=>2]);
        }

    }
    private function setEvaluate(){
        $orderModel = new Order();
        $orderProductModel = new OrderProduct();
        $condition = [
            'is_pay' => 1,
            'status' => OrderStatusEnum::RECEIVE,
            'is_delivery' =>1
        ];

        $orders = $orderModel->where($condition)->whereTime('confirm_time','<','-7 days')->field('id,user_id')->select();
        if($orders){
            $orderIds = array_column($orders,'id');
            $orderModel->where('id','in',$orderIds)->update(['status'=>OrderStatusEnum::EVALUATE]);
            $orderProductModel->where('order_id','in',$orderIds)->update(['evaluate'=>2]);
            $this->createComment($orderIds);
        }
    }

    private function createComment($orderIds){
        $orderProductModel = new OrderProduct();
        $commentModel = new ProductComment();
        $orderProducts = $orderProductModel->with(['goodsOrder'=>function($query){
            $query->field('id,user_id');
        }])->where('order_id','in',$orderIds)->select();
        if($orderProducts){
            $productComments = [];
            foreach ($orderProducts as $orderProduct){
                $data = [
                    'user_id' => $orderProduct['goodsOrder']['user_id'],
                    'order_id' => $orderProduct['order_id'],
                    'product_id' => $orderProduct['product_id'],
                    'content' => '此用户没有评价,系统默认好评',
                ];
                array_push($productComments,$data);
            }
            $commentModel->isUpdate(false)->saveAll($productComments);
        }
    }


}