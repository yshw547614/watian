<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/24 0024
 * Time: 上午 9:11
 */

namespace app\admin\controller;

use app\admin\model\AuthRule;
use app\common\response\RequestResponse;
use think\Request;

class Rule extends BaseController
{

    public function index(){
        return $this->fetch();
    }
    public function getList(){
        $authRule = new AuthRule();
        $data = $authRule->getTreeResult('id','pid');
        return $data;
    }
    public function edit(){
        return $this->fetch();
    }
    public function getParents(){
        $data = [];
        $authRule = new AuthRule();
        $rows = $authRule->getTreeResult('id','pid');
        foreach ($rows as $row){
            if($row['level'] != 3){
                array_push($data,$row);
            }
        }
        return $data;
    }
    public function getOneData(){
        $id = request()->param('id');
        $data = model('AuthRule')->where('id',$id)->find();
        if(!$data){
            return RequestResponse::getResponse('错误参数id','error',0);
        }
        return $data;
    }
    public function saveData(){
        $post = input('post.');
        $isUpdate = isset($post['id'])?true:false;
        model('AuthRule')->isUpdate($isUpdate)->save($post);
        return RequestResponse::getResponse();
    }


    public function delete(){
        $id = input('post.id');
        $data = model('AuthRule')->where('id',$id)->find();
        if(!$data){
            return RequestResponse::getResponse('错误参数id','error',0);
        }
        $num = model('AuthRule')->where('pid',$id)->count();
        if($num>0){
            return RequestResponse::getResponse('请先删除该项目下子项目','error',0);
        }
        model('AuthRule')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }

}