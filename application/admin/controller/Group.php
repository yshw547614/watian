<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/27 0027
 * Time: 上午 11:38
 */

namespace app\admin\controller;


use app\admin\model\AuthGroup;
use app\common\response\RequestResponse;

class Group extends BaseController
{
    public function index(){
        return $this->fetch();
    }
    public function edit(){
        return $this->fetch();
    }
    public function getOneData(){
        $id = request()->param('id');
        $data = model('AuthGroup')->where('id',$id)->find();
        return $data;
    }
    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $list = model('AuthGroup')->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'count' => $list['total'],
            'data' => $list['data'],
        ];
        return $data;
    }
    public function getRules(){
        $ruleStr = request()->param('rule_str');
        $rows = model('AuthRule')->field('id,pid,title')->select()->toArray();
        $data = $this->getChildren($ruleStr,$rows);
        return $data;
    }

    public function updateField(){
        $data = input('post.');
        model('AuthGroup')->isUpdate(true)->save($data);
        return RequestResponse::getResponse();
    }
    public function saveData(){
        $post = input('post.');
        $post['status'] = $post['status']=='on'?1:0;
        $isUpdate = isset($post['id'])?true:false;
        model('AuthGroup')->isUpdate($isUpdate)->save($post);
        return RequestResponse::getResponse();
    }
    public function delete(){
        $id = input('post.id');
        $row = model('AuthGroup')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数Id','error',0);
        }
        $num = model('Admin')->where('group_id',$id)->count();
        if($num>0){
            return RequestResponse::getResponse('请先删除该用户组下的管理员','error',0);
        }
        model('AuthGroup')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
    public function getChildren($ruleStr,$data,$pid=0,$fieldPid='pid',$level=1,$maxLevel=4){
        $arr = [];
        $i = 0;
        foreach($data as $v) {
            if($v[$fieldPid]==$pid){
                $arr[$i]['title']=$v['title'];
                $arr[$i]['value']=$v['id'];
                if($ruleStr){
                    $ruleArr = explode(',',$ruleStr);
                    $arr[$i]['checked'] = in_array($v['id'],$ruleArr)?true:false;
                }
                $level<$maxLevel && $arr[$i]['data']=$this->getChildren($ruleStr,$data,$v['id'],$fieldPid,$level+1);
                $i++;
            }

        }
        return $arr;
    }
}