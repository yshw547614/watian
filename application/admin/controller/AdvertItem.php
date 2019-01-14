<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/5 0005
 * Time: 下午 3:49
 */

namespace app\admin\controller;
use app\admin\model\AdvertItem as ItemModel;

class AdvertItem extends BaseController
{
    public function index($advertid){
        $itemModel = new ItemModel();
        $list = $itemModel->where('advert_id',$advertid)->select();
        return $this->fetch('index',['advertid'=>$advertid,'list'=>$list]);
    }

    public function getBanners(){
        $banners = model('AdvertItem')->where('advert_id',1)->order('rank asc')->select();
        return json($banners);
    }
    public function add(){
        $itemModel = new ItemModel();
        if(request()->isPost()){
            $itemModel->add();
        }else{
            $advertid = request()->param('advertid');
            return $this->fetch('items',['advertid'=>$advertid,'type'=>'add']);
        }
    }

    public function edit(){
        $id = request()->param('id');
        $itemModel = new ItemModel();
        $item = $itemModel->isHasRecord($id);
        if(request()->isPost()){
            $itemModel->edit($id,$item);
        }else{
            validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
            return $this->fetch('items',['item'=>$item,'type'=>'edit']);
        }
    }

    public function del($id){
        $itemModel = new ItemModel();
        validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
        $itemModel->del($id);

    }

}