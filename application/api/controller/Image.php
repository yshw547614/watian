<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/15 0015
 * Time: 下午 3:54
 */

namespace app\api\controller;

use app\api\model\Images;
use app\api\service\ApiImage;
use app\api\validate\IDMustBePositiveInt;
use app\common\response\RequestResponse;

class Image
{
    public function upload(){
        $image = new ApiImage();
        $imageInfo = $image->uploadFile();
        return RequestResponse::getResponse('','','',$imageInfo);
    }
    public function getImageById($id=-1){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $data = Images::get($id);
        if($data){
            $data->hidden(['id']);
            return RequestResponse::getResponse('','','',$data);
        }else{
            return RequestResponse::getResponse('错误参数id','error',403);
        }
    }
    public function getWeixinImg(){
        $src = config('domain').'/images/weixin.jpg';
        return RequestResponse::getResponse('','','',['src'=>$src]);
    }
}