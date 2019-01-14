<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/30 0030
 * Time: 上午 11:31
 */

namespace app\admin\controller;
use app\admin\model\Tags as TagsModel;

class Tags extends BaseController
{
    public function index($typeid){
        $tagsModel = new TagsModel();
        $arr = $tagsModel->where('type_id','=',$typeid)->paginate(10);
        return $this->fetch('index',['typeid'=>$typeid,'list'=>$arr]);
    }
    public function add($typeid){
        $tagModel = new TagsModel();
        if(request()->isPost()){
            $data = input('post.');
            $tagModel->addTags($data);
        }else{
            return $this->fetch('add',['typeid'=>$typeid]);
        }
    }
    public function edit(){
        $data = input('post.');
        $tagModel = new TagsModel;
        $res = $tagModel->edit($data);
        return json($res);
    }
    public function del($id){
        $tagModel = new TagsModel();
        validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
        $tagModel->del($id);
    }
}