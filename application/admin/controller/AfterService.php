<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/23 0023
 * Time: 上午 9:33
 */

namespace app\admin\controller;

use app\admin\model\AfterService as AfterServiceModel;
use app\admin\model\Order;
use app\admin\validate\BaseValidate;
use app\common\enum\ReturnStatusEnum;
use app\common\service\Refund;
use app\admin\validate\IdMustBePositiveInt;
use app\common\response\RequestResponse;
use think\Db;
use think\Exception;

class AfterService extends BaseController
{
    public function index(){
        return $this->fetch();
    }

    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $map = $this->getMap($param);

        if(!empty($map)){
            $list = model('AfterService')->with(['user'=>function($query){
                $query->field('id,nickname,head_img');
            }])->where($map)->paginate($limit)->toArray();
        }else{
            $list = model('AfterService')->with(['user'=>function($query){
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
            'count' => $list['total'],
            'data' => $dataRows,
        ];
        return json($data);
    }
    public function getMap($param){
        $map = [];
        if(isset($param['status'])){
            $map['status'] = $param['status'];
        }
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
            if($param['order_no']) {
                $map['order_no'] =['like','%'.$param['order_no'].'%'];
            }
        }
        return $map;
    }
    public function isExist(){
        $id = input('post.id');
        $row = model('AfterService')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数Id','error');
        }
        return RequestResponse::getResponse();
    }

    public function detail($id=-1){
        $validate = new IdMustBePositiveInt();
        $validate->checkData(['id'=>$id],true);
        $model = new AfterServiceModel();
        $query = $model->getAfterService();
        $data = $query->where('id',$id)->find();
        if(!$data){
            RequestResponse::getResponse('错误参数Id','error');
        }
        $user = model('User')->where('id',$data['user_id'])->field('nickname,head_img')->find();
        $data['user'] = $user;
        return $this->fetch('detail',['data'=>$data]);
    }

    public function through(){
        $id = input('post.service_id');
        $afterService = model('AfterService')->get($id);
        if(!$afterService){
            RequestResponse::getResponse('错误id参数','error');
        }
        $time = config('return.delivery_delay_time');
        $dateTime = date('m月d日 H:i',$time);
        $remark = '请您在'.$dateTime.'前将商品按如下地址寄回，逾期将自动取消申请';
        $afterService->status = ReturnStatusEnum::THROUGH;
        $afterService->remark = $remark;
        $afterService->save();
        return RequestResponse::getResponse();
    }
    public function confirm(){
        $id = input('post.service_id');
        $afterService = model('AfterService')->get($id);
        if(!$afterService){
            RequestResponse::getResponse('错误id参数','error');
        }
        $afterService->remark = '商品已入库，请等待卖家退款到您账户';
        $afterService->status = ReturnStatusEnum::RECEIVE;
        $afterService->save();

        $orderProductIds = model('AfterServiceProduct')
            ->where('after_service_id',$id)->column('order_product_id');

        $products = model('OrderProduct')->field('product_id id,count')
            ->where('id','in',$orderProductIds)->select();
        foreach ($products as $product){
            model('Product')->where('id',$product['id'])->setInc('stock',$product['count']);
        }
        return RequestResponse::getResponse('操作成功');
    }


    public function refund(){
        $id = input('post.service_id');
        $afterService = AfterServiceModel::get($id);
        if(!$afterService){
            RequestResponse::getResponse('错误id参数','error');
        }
        $refundParame = $this->getRefundParame($afterService);
        $result = Refund::refund($refundParame);
        if($result['result_code']==='SUCCESS'){
            $data = [
                'id' => $afterService['id'],
                'remark' => '相关款项已经根据您的选择退还给您的账号，请注意查收',
                'status' => ReturnStatusEnum::FINISH,
                'refund_time' => time(),
            ];
            $afterService->save($data);
            return RequestResponse::getResponse('退款成功');
        }else{
            throw new Exception($result['err_code_des'],506);
        }
    }

    private function getRefundParame($afterService){
        $order = Order::get($afterService['order_id']);
        $total_fee = $order['total_fee'];
        $refund_fee = $afterService['refund_money']*100;
        $refundParame = [
            'transaction_id' => $order['transaction_id'],
            'out_refund_no' => $afterService['out_refund_no'],
            'total_fee' => $total_fee,
            'refund_fee' => $refund_fee
        ];
        return $refundParame;

    }

    public function autoCheck(){
        return $this->fetch('auto_check');
    }

    public function getReturnReason(){
        $data = [];
        $reasons = config('return.reason');
        $selects = model('ReturnSet')->column('reason_num');
        foreach ($reasons as $key => $reason){
            $temp['reason_num'] = $key;
            $temp['title'] = $reason;
            $temp['is_checked'] = in_array($key,$selects)?true:false;
            array_push($data,$temp);
        }
        return json($data);
    }
    public function saveReturnSet(){
        $data = [];
        $post = input('post.');
        $reasons = array_keys($post['reason']);
        foreach ($reasons as $reason){
            $data[]['reason_num'] = $reason;
        }
        Db::execute('truncate table wt_return_set');
        model('ReturnSet')->saveAll($data);
        return RequestResponse::getResponse();
    }

    public function delete(){
        $id = input('post.id');
        $row = model('AfterService')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误id参数','error');
        }
        model('AfterService')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }

}