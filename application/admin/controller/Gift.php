<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/7 0007
 * Time: 下午 4:31
 */

namespace app\admin\controller;

use app\admin\model\Gift as GiftModel;

class Gift extends BaseController
{
    protected $imgUploadPath;
    public function _initialize()
    {
        parent::_initialize();
        $this->imgUploadPath = config('gift.images_upload_path');
    }

    public function index(){
        $list = GiftModel::all();
        return $this->fetch('index',['list'=>$list]);
    }
    public function add(){
        $giftModel = new GiftModel();
        if(request()->isPost()){
            $data = input('post.');
            validate('Gift')->checkData($data);
            if($file = request()->file('image'))
            $data['image'] = $giftModel->addThumb($file,$this->imgUploadPath);
            $giftModel->isUnique(['name'=>$data['name']],'礼品名称');
            $giftModel->addRecord($data,url('index'),'礼品');
        }else{
            return $this->fetch('gift',['type'=>'add']);
        }
    }
    public function edit(){
        $id = request()->param('id');
        $giftModel = new GiftModel();
        $gift = $giftModel->isHasRecord($id);
        if(request()->isPost()){
            $data = input('post.');
            validate('Gift')->checkData($data);
            if($file = request()->file('image'))
            $data['image'] = $gift->updataThumb($file,$gift->getData('image'),$this->imgUploadPath);
            $giftModel->isUnique(['name'=>$data['name'],'id'=>['neq',$gift['id']]],'礼物名称');
            $giftModel->updateRecord($data,url('index'),'礼物');
        }else{
            validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
            return $this->fetch('gift',['gift'=>$gift,'type'=>'edit']);
        }
    }
    public function del($id){
        $category = new CategoryModel();
        validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
        $category->isHasRecord($id);
        $data = CategoryModel::all()->toArray();
        $delIds = getChildrenIds($id,$data);
        $delIds[] = $id;
        $category->del($delIds);
    }
}