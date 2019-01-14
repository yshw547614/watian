<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/21 0021
 * Time: 下午 1:57
 */

namespace app\api\model;


use think\Model;
use app\api\service\ApiImage;
use app\common\response\RequestResponse;

class Picture extends Model
{
    protected $imgUploadPath;

    public function initialize()
    {
        $this->imgUploadPath = config('user.album_upload_path');
    }

    public function change(){
        $image = new ApiImage();
        $data = input('post.');
        $isUpdate = isset($data['id'])?true:false;
        $imageInfo = $image->uploadFile();
        $imageId = $imageInfo['data']['id'];
        if($isUpdate){
            if(!$row = $this->where('id',$data['id'])->find()){
                return RequestResponse::getResponse('文件对应Id参数错误','error',404);
            }
            $image->deleteImg($this->imgUploadPath.$row->getData('image'));
        }
        $data['image'] = $saveName;
        $result = $this->isUpdate($isUpdate)->save($data);
        return RequestResponse::getResponseByResult($result);
    }

    public function del($id){
        $result = $this->where('id',$id)->delete();
        return RequestResponse::getResponseByResult($result);
    }
    public function updateRank(){
        $data = input('post.images/a');
        $result = $this->saveAll($data);
        return RequestResponse::getResponseByResult($result);
    }
}