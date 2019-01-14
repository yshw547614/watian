<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/27 0027
 * Time: 上午 10:42
 */

namespace app\admin\controller;

use app\admin\model\ScoreRule;


class Score extends BaseController
{
    public function index(){
        $rules = ScoreRule::all();
        return $this->fetch('index',['list'=>$rules]);
    }
    public function add(){
        return $this->fetch('rule',['type'=>'add']);
    }
    public function edit($id){
        $rule = ScoreRule::get($id);
        return $this->fetch('rule',['data'=>$rule,'type'=>'edit']);
    }
    public function rule(){
        $scoreRule = new ScoreRule();
        $scoreRule->handle();
    }
}