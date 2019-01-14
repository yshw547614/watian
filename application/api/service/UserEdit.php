<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/15 0015
 * Time: 下午 4:08
 */

namespace app\api\service;

use app\api\service\Token;
use app\common\response\RequestResponse;
use app\api\model\User;
use app\api\model\UserAddons;
use app\api\service\ApiImage;

class UserEdit
{
    public static function editHeadImg(){
        $uid = Token::getCurrentTokenVar('uid');
        $user = User::get($uid);
        $image = new ApiImage();
        $imgSavePath = config('user.images_upload_path');
        $imageInfo = $image->fileRule();
        $imageId = $imageInfo['id'];
        if($fileName = $user->getData('img')){
            $image->deleteImg(config('user.images_upload_path').$fileName);
        }
        $user->img = $imageId;
        $result = $user->save();
        return RequestResponse::getResponseByResult($result,'','','',['headimg'=>$user->img]);
    }

    public static function editUser(){
        $data = input('post.');
        $uid = Token::getCurrentTokenVar('uid');
        $result = self::where('id',$uid)->update($data);
        return RequestResponse::getResponseByResult($result);

    }
    public static function editUserAddons(){
        $data = input('post.');
        $uid = Token::getCurrentTokenVar('uid');
        $addons = UserAddons::get(['user_id'=>$uid]);
        if($addons){
            $result = UserAddons::create($data);
        }else{
            $result = UserAddons::where('user_id',$uid)->update($data);
        }
        return RequestResponse::getResponseByResult($result);
    }

}