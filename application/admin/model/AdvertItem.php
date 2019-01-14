<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/5 0005
 * Time: 下午 4:31
 */

namespace app\admin\model;
use app\common\service\Images;

class AdvertItem extends BaseModel
{
    protected $imgUploadPath;

    public function initialize()
    {
        $this->imgUploadPath = config('product.images_upload_path');
    }

    public function add(){
        $data = input('post.');
        validate('AdvertItem')->checkData($data);
        if($file = request()->file('img_url')){
            $image = new Images();
            $saveName = $image->uploadImg($file,$this->imgUploadPath);
            $data['img_url'] = $saveName;
        }
        $this->addRecord($data,url('index',['advertid'=>$data['advert_id']]),'广告项');
    }
    public function edit($id,$item){
        $data = input('post.');
        validate('AdvertItem')->checkData($data);
        if($file = request()->file('img_url')){
            $image = new Images();
            $fileName = $this->where('id',$id)->value('img_url');
            $imagePath = $this->imgUploadPath.$fileName;
            $image->deleteImg($imagePath);
            $saveName = $image->uploadImg($file,$this->imgUploadPath);
            $data['img_url'] = $saveName;
        }
        $this->isHasNewData($data,$item);
        $this->updateRecord($data,url('index',['advertid'=>$item['advert_id']]),'广告项');
    }
    public function del($id){
        $flag = false;
        $image = new Images();
        $item = self::get($id);
        $imgSavePath = $this->imgUploadPath.$item->getData('img_url');
        $image->deleteImg($imgSavePath) && $flag = true;
        $this::destroy($id) && $flag = true;
        if($flag){
            $this->success('数据删除成功！',url('index',['advertid'=>$item['advert_id']]));
        }else{
            $this->error('数据删除失败');
        }
    }
}