<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/11 0011
 * Time: 下午 8:01
 */

namespace app\admin\controller;

use app\common\response\RequestResponse;

class HelpType extends BaseController
{
    public function index(){
        return $this->fetch('help/category');
    }
    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $list = model('HelpType')->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => $list['total'],
            'data' => $list['data'],
        ];
        return $data;
    }

    public function updateField(){
        $post = input('post.');
        model('HelpType')->isUpdate(true)->save($post);
        return RequestResponse::getResponse();
    }
    public function saveAdd(){
        $post = input('post.');
        model('HelpType')->allowField('title')->isUpdate(false)->save($post);
        return RequestResponse::getResponse();
    }

    public function delete(){
        $id = input('post.id');
        $row = model('HelpType')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数id','error');
        }
        $helpNums = model('Help')->where('type_id',$id)->count();
        if($helpNums>0){
            return RequestResponse::getResponse('请先删除该分类下的帮助文档','error');
        }
        model('HelpType')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
}