<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/30 0030
 * Time: 下午 2:19
 */

namespace app\admin\controller;
use app\admin\model\TagsType as TagsTypeModel;

class TagsType extends BaseController
{
    public function index(){
        $arr = TagsTypeModel::all();
        return $this->fetch('type/index',['list'=>$arr,'type'=>'tags']);
    }
    public function add(){
        $tagsType = new TagsTypeModel();
        $rule = ['title|分类标题' => 'require|max:30|isNotEmpty|unique:tags_type'] ;
        $data = input('post.');
        $res = $tagsType->add($data,$rule);
        return $res;
    }
    public function edit(){
        $tagsType = new TagsTypeModel();
        $rule = ['title|分类标题' => 'require|max:30|isNotEmpty'] ;
        $data = input('post.');
        $res = $tagsType->edit($data,$rule);
        return $res;
    }
    public function del($id){
        $tagsTypeModel = new TagsTypeModel();
        validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
        $tagsTypeModel->del($id);
    }
}