<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/20 0020
 * Time: 下午 6:13
 */

namespace app\api\model;


use think\Model;
use app\api\service\Token;
use app\common\response\RequestResponse;

class UserNameProve extends Model
{
    protected $imgSavePath;

    public function initialize()
    {
        $this->imgSavePath = config('user.identity_save_path');
    }

    public function editIdentify(){
        $data = input('post.');
        $uid = Token::getCurrentTokenVar('uid');
        $row = self::get(['user_id'=>$uid]);
        if($row){
            $this->deleteIdentityImg($data,$row);
            $result = self::where('user_id',$uid)->update($data);
        }else{
            $result = self::create($data);
        }
        return RequestResponse::getResponseByResult($result);
    }

    public function uploadIdentityImg(){
        $image = new ApiImage();
        return $image->uploadFile($this->imgSavePath);
    }

    public function delIdentityImg(){
        $image = new ApiImage();
        $data = input('post.');
        $imgSavePath = $this->imgSavePath.$data['imgName'];
        return $image->deleteFile($imgSavePath);
    }

    public function deleteIdentityImg($postData,$dbData){
        $image = new ApiImage();
        if(!empty($postData['obverse_img']) && $postData['obverse_img'] != $dbData['obverse_img']){
            $image->deleteImg($this->imgSavePath.$dbData['obverse_img']);
        }
        if(!empty($postData['opposite_img']) && $postData['opposite_img'] != $dbData['opposite_img']){
            $image->deleteImg($this->imgSavePath.$dbData['opposite_img']);
        }
    }
}