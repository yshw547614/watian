<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/12 0012
 * Time: 上午 9:43
 */

namespace app\admin\controller;

use app\admin\model\Express as ExpressModel;
use app\common\response\RequestResponse;

class Express extends BaseController
{
    public function index(){
        return $this->fetch('logistics/express');
    }
    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $list = model('Express')->order('id desc')->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'count' => $list['total'],
            'data' => $list['data']
        ];
        return json($data);
    }
    public function updateField(){
        $data = input('post.');
        model('Express')->isUpdate(true)->save($data);
        $result = RequestResponse::getResponse();
        return json($result);
    }
    public function saveAdd(){
        $post = input('post.');
        model('Express')->isUpdate(false)->save($post);
        return RequestResponse::getResponse();
    }

    public function delete(){
        $id = input('post.id');
        $row = model('Express')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数id','error');
        }
        $orderNums = model('Order')->where('express_id',$id)->count();
        if($orderNums>0){
            return RequestResponse::getResponse('请先删除使用改快递的订单','error');
        }
        model('Express')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
}