<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/19 0019
 * Time: 下午 7:50
 */

namespace app\api\service;

use app\common\service\Images;
use app\api\model\Images as ImagesModel;
use app\common\response\RequestResponse;
use think\Exception;

class ApiImage extends Images
{
    public function uploadFile(){
        $data = input('post.');
        if(!isset($data['file_name'])){
            throw new Exception('错误参数',400);
        }
        if(!$file = request()->file($data['file_name'])){
            throw new Exception('文件对应的key参数错误',404);
        }
        $imgWebPath = config('user.images_web_path');
        $imgSavePath = config('user.images_upload_path');
        if(!$info = $file->rule([$this,'fileRule'])->move($imgSavePath)){
            throw new Exception($file->getError(),405);
        }else{
            $saveName = $info->getSaveName();
            $imgPath = $imgSavePath.$saveName;
            $this->imageCompress($imgPath);
            $imgUrl = $imgWebPath.$saveName;
            $result = ImagesModel::create(['url'=>$imgUrl]);
            return $result;
        }
    }
    public function fileRule(){
        $date = date('Ymd');
        $fileName = md5(uniqid());
        return $date.'/'.$fileName;
    }
    public function deleteFile($fileSavePath){
        $flag = $this->deleteImg($fileSavePath);
        return RequestResponse::getResponseByResult($flag);
    }
}