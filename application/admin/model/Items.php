<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/27 0027
 * Time: 上午 10:07
 */

namespace app\admin\model;

use app\common\service\Images;
class Items extends BaseModel
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
            $fileName = ItemModel::where('id',$id)->value('img_url');
            $imagePath = $this->imgUploadPath.$fileName;
            $image->deleteImg($imagePath);
            $saveName = $image->uploadImg($file,$this->imgUploadPath);
            $data['img_url'] = $saveName;
        }
        $this->isHasNewData($data,$item);
        $this->updateRecord($data,url('index',['advertid'=>$item['advert_id']]),'广告项');
    }
}