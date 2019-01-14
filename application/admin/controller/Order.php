<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/29
 * Time: 22:09
 */

namespace app\admin\controller;

use app\admin\model\Order as OrderModel;
use app\common\enum\OrderStatusEnum;
use app\common\response\RequestResponse;

class Order extends BaseController
{
    public function index(){
        return $this->fetch();
    }
    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $map = $this->getMap($param);
        if(!empty($map)){
            $list = model('Order')->with(['user'=>function($query){
                $query->field('id,nickname,head_img');
            }])->where($map)->paginate($limit)->toArray();
        }else{
            $list = model('Order')->with(['user'=>function($query){
                $query->field('id,nickname,head_img');
            }])->paginate($limit)->toArray();
        }

        $dataRows = $list['data'];
        foreach ($dataRows as &$dataRow){
            $dataRow['nickname'] = $dataRow['user']['nickname'];
            $dataRow['head_img'] = $dataRow['user']['head_img'];
            unset($dataRow['user']);
        }
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'param' => $param,
            'count' => $list['total'],
            'data' => $dataRows,
        ];
        return json($data);
    }
    public function getMap($param){
        $map = [];
        if(isset($param['is_search'])){
            if($param['begin_time'] && $param['end_time']){
                $map['create_time'] = ['between time',[$param['begin_time'],$param['end_time']]];
            }
            if($param['begin_time'] && !$param['end_time']){
                $map['create_time'] = ['>= time',$param['begin_time']];
            }
            if(!$param['begin_time'] && $param['end_time']){
                $map['create_time'] = ['<= time',$param['end_time']];
            }
            if($param['order_id']) {
                $map['id'] = $param['order_id'];
            }
            if($param['order_no']) {
                $map['order_no'] =['like','%'.$param['order_no'].'%'];
            }
            if($param['name']){
                $map['json_extract(snap_address,  \'$.name\' )'] = ['like','%'.$param['name'].'%'];
            }
            if($param['mobile']){
                $map['json_extract(snap_address,  \'$.mobile\' )'] = ['like','%'.$param['mobile'].'%'];
            }
        }
        if(isset($param['status'])){
            $map['status'] = $param['status'];
        }
        return $map;
    }

    public function getStatus(){
        $status = OrderStatusEnum::getOrderStatus();
        return $status;
    }

    public function delivery(){
        $orderModel = new OrderModel();
        return $orderModel->delivery();
    }
    public function detail($id){
        $data = OrderModel::getDetail($id);
        $options = OrderStatusEnum::getOrderStatus();
        return $this->fetch('detail',['data'=>$data,'options'=>$options]);
    }
    public function delete(){
        $id = input('post.id');
        $afterServiceNums = model('AfterService')->where('order_id',$id)->count();
        if($afterServiceNums>0){
            return RequestResponse::getResponse('此订单包含了申请退货退款的商品,请先删除对应的退款退货记录');
        }
        model('Order')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
}