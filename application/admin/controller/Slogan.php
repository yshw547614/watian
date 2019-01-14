<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/19 0019
 * Time: 上午 9:42
 */

namespace app\admin\controller;


use app\admin\validate\BaseValidate;
use app\admin\model\Slogan as SloganModel;
use app\common\response\RequestResponse;

class Slogan extends BaseController
{
    public function index(){
        $list = model('Slogan')->select();
        return $this->fetch('index',['list'=>$list]);
    }
    public function getList(){
        $list = model('Slogan')->limit(3)->order('id asc')->select();
        return json($list);
    }
    public function add(){
        $data = input('post.');
        $this->checkData($data);
        model('Slogan')->save($data);
        return RequestResponse::getResponse('添加成功');

    }
    public function edit(){
        $data = input('post.');
        $this->checkData($data);
        model('Slogan')->isUpdate(true)->save($data);
        return RequestResponse::getResponse('修改成功');
    }
    public function checkData($data){
        $rule = [
            'title|广告标语标题' => 'require|max:30|isNotEmpty|unique:slogan',
            'link|链接地址' => 'require|isNotEmpty',
        ] ;
        $validate = new BaseValidate($rule);
        $validate->checkData($data,true);
    }
    public function delete(){
        $id = input('post.id');
        $model = new SloganModel();
        $model->isHasRecord($id,true);
        $model->where('id',$id)->delete();
        return RequestResponse::getResponse('刪除成功');
    }
}