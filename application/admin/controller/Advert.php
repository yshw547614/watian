<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/5 0005
 * Time: 下午 3:19
 */

namespace app\admin\controller;
use app\common\response\RequestResponse;

class Advert extends BaseController
{
    public function index(){
        return $this->fetch();
    }

    public function getList(){
        $param = request()->param();
        $list = model('AdvertItem')->where('advert_id',$param['advert_id'])->select()->toArray();
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'count' => count($list),
            'data' => $list
        ];
        return $data;

    }
    public function saveData(){
        $post = input('post.');
        $isUpdate = isset($post['id'])?true:false;
        model('AdvertItem')->isUpdate($isUpdate)->save($post);
        return RequestResponse::getResponse();
    }


    public function getData(){
        $id = request()->param('id');
        $data = model('AdvertItem')->where('id',$id)->find();
        return $data;
    }

    public function edit(){
        return $this->fetch();
    }
    public function delete(){
        $id = input('post.id');
        $row = model('AdvertItem')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数Id','error');
        }
        model('AdvertItem')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
}