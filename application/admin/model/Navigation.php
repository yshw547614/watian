<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/27 0027
 * Time: 上午 10:33
 */

namespace app\admin\model;
use app\admin\validate\BaseValidate;
use app\common\service\Images;

class Navigation extends BaseModel
{
    protected $imgUploadPath;

    public function initialize()
    {
        $this->imgUploadPath = config('product.images_upload_path');
    }

    public function add(){
        $data = input('post.');
        if($file = request()->file('icon')){
            $image = new Images();
            $saveName = $image->uploadImg($file,$this->imgUploadPath);
            $data['icon'] = $saveName;
        }
        $rule = [
            'title' => 'require|isNotEmpty|max:50',
            'icon' => 'require|isNotEmpty',
            'link' => 'require|isNotEmpty'
        ];
        $validate = new BaseValidate($rule);
        $validate->checkData($data);
        $this->addRecord($data,url('index'),'导航项目');
    }
    public function edit($id,$item){
        $data = input('post.');
        if($file = request()->file('icon')){
            $image = new Images();
            $fileName = $this->where('id',$id)->value('icon');
            $imagePath = $this->imgUploadPath.$fileName;
            $image->deleteImg($imagePath);
            $saveName = $image->uploadImg($file,$this->imgUploadPath);
            $data['icon'] = $saveName;
        }
        $rule = [
            'title' => 'require|isNotEmpty|max:50',
            'link' => 'require|isNotEmpty'
        ];
        $validate = new BaseValidate($rule);
        $validate->checkData($data);
        $this->isHasNewData($data,$item);
        $this->updateRecord($data,url('index'),'导航项目');
    }
    public function del($id){
        $flag = false;
        $image = new Images();
        $item = self::get($id);
        $imgSavePath = $this->imgUploadPath.$item->getData('icon');
        $image->deleteImg($imgSavePath) && $flag = true;
        $this::destroy($id) && $flag = true;
        if($flag){
            $this->success('数据删除成功！',url('index'));
        }else{
            $this->error('数据删除失败');
        }
    }
}