<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/27 0027
 * Time: 上午 10:03
 */

namespace app\admin\controller;
use app\admin\model\Navigation as NavigationModel;

class Navigation extends BaseController
{
    public function index(){
        $list = NavigationModel::all();
        return $this->fetch('index',['list'=>$list]);
    }
    public function getList(){
        $list = model('Navigation')->order('rank asc')->limit(10)->select();
        return json($list);
    }
    public function add(){
        $model = new NavigationModel();
        if(request()->isPost()){
            $model->add();
        }else{
            return $this->fetch('navigation',['type'=>'add']);
        }
    }

    public function edit(){
        $id = request()->param('id');
        $model = new NavigationModel();
        $item = $model->isHasRecord($id);
        if(request()->isPost()){
            $model->edit($id,$item);
        }else{
            validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
            return $this->fetch('navigation',['item'=>$item,'type'=>'edit']);
        }
    }

    public function del($id){
        $model = new NavigationModel();
        validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
        $model->del($id,'icon');
    }
}