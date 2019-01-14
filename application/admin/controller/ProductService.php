<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/15 0015
 * Time: 下午 3:02
 */

namespace app\admin\controller;

use app\common\response\RequestResponse;

class ProductService extends BaseController
{


    public function index(){
        return $this->fetch('after_service/service_item');
    }

    public function updateField(){
        $post = input('post.');
        model('ProductService')->isUpdate(true)->save($post);
        return RequestResponse::getResponse();
    }
    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $list = model('ProductService')->order('id desc')->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg'=>'ok',
            'count'=>$list['total'],
            'data' => $list['data']
        ];
        return $data;
    }
    public function saveAdd(){
        $post = input('post.');
        model('ProductService')->isUpdate(false)->save($post);
        return RequestResponse::getResponse();
    }


    public function delete(){
        $id = input('post.id');
        $row = model('ProductService')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数id','error');
        }
        $rows = model('ProductServiceTemplate')->select()->toArray();
        $items = array_column($rows,'service_ids');
        foreach ($items as $item){
            if(in_array($id,$item)){
                return RequestResponse::getResponse('请先删除使用该服务项的售后服务模板','error');
            }
        }
        model('ProductService')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
}