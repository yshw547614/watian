<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/28 0028
 * Time: 下午 5:37
 */

namespace app\admin\controller;

use app\common\response\RequestResponse;
use app\admin\validate\ShippingRule as ShippingRuleValidate;

class Shipping extends BaseController
{
    public function index(){
        return $this->fetch();
    }
    public function shipping(){
        return $this->fetch();
    }
    public function getList(){
        $param = request()->param();
        model('ShippingRule')->where(['is_long_term'=>0,'end_time'=>['<',time()]])->update(['status'=>-1]);
        $list = model('ShippingRule')->order('id desc')->paginate($param['limit'])->toArray();
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'count' => $list['total'],
            'data' => $list['data'],
        ];
        return json($data);
    }
    public function updateField(){
        $data = input('post.');
        model('ShippingRule')->isUpdate(true)->save($data);
        $result = RequestResponse::getResponse();
        return json($result);
    }
    public function getRule(){
        $id = request()->param('id');
        $row = model('ShippingRule')->where('id',$id)->find()->toArray();
        return json($row);
    }
    public function getRuleItems(){
        $id = request()->param('id');
        $rows = model('ShippingRuleItem')->where('rule_id',$id)->select()->toArray();
        foreach ($rows as &$row){
            $exc_region = model('Region')->where('id','in',$row['exc_region'])->column('name');
            $row['exc_region_name'] = implode(',',$exc_region);
        }
        return json($rows);
    }
    public function getProducts(){
        $param = request()->param();
        $limit = $param['limit'];
        $product_ids = $param['product_ids'];
        $list = model('product')->where('id','in',$product_ids)->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'count' => $list['total'],
            'data' => $list['data'],
        ];
        return json($data);

    }
    public function saveData(){
        $model = model('ShippingRule');
        $post = input('post.');
        $isUpdate = isset($post['id']) ? true : false;
        $data = [
            'title' => $post['title'],
            'start_time' => strtotime($post['start_time']),
            'end_time' => strtotime($post['end_time']),
            'is_long_term' => $post['is_long_term'],
            'is_all_product' => $post['is_all_product'],
            'product_ids' => $post['product_ids']
        ];
        $isUpdate && $data['id'] = $post['id'];
        $model->isUpdate($isUpdate)->save($data);
        $this->updateRuleItem($post['item'],$model->id);
        $result = RequestResponse::getResponse();
        return json($result);
    }
    public function updateRuleItem($posts,$ruleId){
        $total = model('ShippingRuleItem')->where('rule_id',$ruleId)->count();
        $postRuleIds = array_column($posts,'id');
        $count = count($postRuleIds);
        if($count<$total){
            model('ShippingRuleItem')->where('id','not in',$postRuleIds)->delete();
        }
        foreach ($posts as &$post){
            $post['rule_id'] = $ruleId;
        }
        model('ShippingRuleItem')->saveAll($posts);
    }

    public function updateStatus(){
        $post = input('post.');
        $row = model('ShippingRule')->where('id',$post['id'])->find();
        if(!$row){
            return json(RequestResponse::getResponse('操作的数据不存在','error',403));
        }
        if($post['status']=='1' && $row['end_time']<time() && $row['is_long_term']=='0'){
            return json(RequestResponse::getResponse('请编辑生效时间','error',406));
        }
        model('ShippingRule')->isUpdate(true)->save($post);
        return json(RequestResponse::getResponse());
    }

    public function delete(){

    }





    public function delete_item(){
        $id = input('post.id');
        $data = model('ShippingRuleItem')->where('id',$id)->find();
        if(!$data){
            return RequestResponse::getResponse('请求数据不存在');
        }
        model('ShippingRuleItem')->where('id',$id)->delete();
        return RequestResponse::getResponse('操作成功');
    }
}