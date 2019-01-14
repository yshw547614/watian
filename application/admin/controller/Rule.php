<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/24 0024
 * Time: 上午 9:11
 */

namespace app\admin\controller;

use app\admin\model\AuthRule;
use think\Request;

class Rule extends BaseController
{

    public function index(){
        $rules=$this->getRules();
        return $this->fetch('index',['data'=>$rules]);
    }
    public function add(){
        $authRule = new AuthRule();
        if(request()->isPost()){
            $data = input('post.');
            validate('AuthRule')->checkData($data);
            $authRule->isUnique(['name'=>$data['name']],'权限值');
            $authRule->addRecord($data,url('index'),'权限');
        }else{
            $rules=$this->getRules();
            return $this->fetch('rule',['rules'=>$rules,'type'=>'add']);
        }
    }
    public function edit(){
        $id = request()->param('id');
        $authRule = new AuthRule();
        $rule = $authRule->isHasRecord($id);
        if(request()->isPost()){
            $data = input('post.');
            $authRule->isHasNewData($data,$rule);
            validate('AuthRule')->checkData($data);
            $authRule->isUnique(['name'=>$data['name'],'id'=>['neq',$id]],'权限值');
            $authRule->updateRecord($data,url('index'),'权限',['pid','name','title']);
        }else{
            validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
            $rules = $this->getRules();
            unset($rules[$id]);
            return $this->fetch('rule',['rule'=>$rule,'rules'=>$rules,'type'=>'edit']);
        }
    }
    public function delete($id){
        $authRule = new AuthRule();
        validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
        $authRule->isHasRecord($id);
        $rules = AuthRule::all()->toArray();
        $ruleIds = getChildrenIds($id,$rules);
        $ruleIds[]=$id;
        $authRule->delRecord($ruleIds,true);
    }
    public function getRules(){
        $authRule = new AuthRule();
        $rules = $authRule->getTreeResult('id','pid');
        return $rules;
    }
}