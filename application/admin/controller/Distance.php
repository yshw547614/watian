<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/27 0027
 * Time: 下午 2:30
 */

namespace app\admin\controller;


use app\admin\model\DistanceRule;

class Distance extends BaseController
{
    public function index(){
        $rules = DistanceRule::all();
        return $this->fetch('index',['list'=>$rules]);
    }
    public function add(){
        return $this->fetch('rule',['type'=>'add']);
    }
    public function edit($id){
        $rule = DistanceRule::get($id);
        return $this->fetch('rule',['data'=>$rule,'type'=>'edit']);
    }
    public function rule(){
        $distanceRule = new DistanceRule();
        $distanceRule->handle();
    }
}