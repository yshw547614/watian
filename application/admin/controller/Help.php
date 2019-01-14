<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/11 0011
 * Time: 下午 7:51
 */

namespace app\admin\controller;
use app\common\response\RequestResponse;


class Help extends BaseController
{
    public function index(){
        return $this->fetch();
    }
    public function select(){
        return $this->fetch();
    }

    public function help(){
        return $this->fetch();
    }
    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $map = $this->getMap($param);
        if(!empty($map)){
            $products = model('Help')->where($map)->paginate($limit)->toArray();
        }else{
            $products = model('Help')->paginate($limit)->toArray();
        }
        $data = [
            'code' => 0,
            'msg' => '',
            'count' => $products['total'],
            'data' => $products['data'],
        ];
        return $data;
    }
    public function getMap($param){
        $map = [];
        if(isset($param['help_title']) && !empty($param['help_title'])){
            $map['title'] = ['like','%'.$param['help_title'].'%'];
        }
        if(isset($param['help_type']) && !empty($param['help_type'])){
            $map['type_id'] = $param['help_type'];
        }
        return $map;
    }
    public function getCategory(){
        $rows = model('HelpType')->select()->toArray();
        return $rows;
    }

    public function updateField(){
        $post = input('post.');
        model('Help')->isUpdate(true)->save($post);
            return RequestResponse::getResponse();
    }

    public function getData(){
        $id = request()->param('id');
        $row = model('Help')->where('id',$id)->find()->toArray();
        return $row;
    }
    public function saveData(){
        $isUpdate = false;
        $post = input('post.');
        $data = [
            'title' => $post['title'],
            'type_id' => $post['type_id'],
            'content' => $post['content']
        ];
        $data['recommend'] = isset($post['recommend'])?1:0;
        if(isset($post['id'])){
            $data['id'] = $post['id'];
            $isUpdate = true;
        }
        model('Help')->isUpdate($isUpdate)->save($data);
        return RequestResponse::getResponse();
    }

    public function delete(){
        $id = input('post.id');
        $row = model('Help')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数id','error');
        }
        model('Help')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
}