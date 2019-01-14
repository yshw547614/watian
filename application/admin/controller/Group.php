<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/27 0027
 * Time: 上午 11:38
 */

namespace app\admin\controller;


use app\admin\model\AuthGroup;
use app\admin\model\AuthRule;

class Group extends BaseController
{
    public function index(){
        $groups = AuthGroup::all(['status'=>1]);
        return $this->fetch('index',['groups'=>$groups]);
    }
    public function add(){
        $authGroup = new AuthGroup();
        if(request()->isPost()){
            $data = input('post.');
            validate('AuthGroup')->checkData($data);
            !empty($data['rules']) && $data['rules'] = implode(',',$data['rules']);
            $authGroup->isUnique(['title'=>$data['title']],'用户组名称');
            $authGroup->addRecord($data,url('index'),'用户组');
        }else{
            $authRule = new AuthRule();
            $rules = $authRule->getTreeResult('id','pid');
            return $this->fetch('group',['rules'=>$rules,'type'=>'add']);
        }
    }
    public function edit(){
        $id = request()->param('id');
        $authGroup = new AuthGroup();
        $group = $authGroup->isHasRecord($id);
        if(request()->isPost()){
            $data = input('post.');
            validate('AuthGroup')->checkData($data);
            !empty($data['rules']) && $data['rules'] = implode(',',$data['rules']);
            $authGroup->isHasNewData($data,$group);
            $authGroup->isUnique(['title'=>$data['title'],'id'=>['neq',$group['id']]],'用户组名称');
            $authGroup->updateRecord($data,url('index'),'用户组',['title','status','rules']);
        }else{
            validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
            $rulesArr = AuthRule::all()->toArray();
            $treeRules = $authGroup->getRules($rulesArr);
            return $this->fetch('group',['group'=>$group,'rules'=>$treeRules,'type'=>'edit']);
        }
    }
    public function del($id){
        $authGroup = new AuthGroup();
        validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
        $authGroup->isHasRecord($id);
        $authGroup->del($id);
    }
}