<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/13 0013
 * Time: 下午 3:04
 */

namespace app\api\controller;

use app\api\model\Images;
use app\api\model\User as UserModel;
use app\api\service\Encrypted;
use app\api\service\Token;
use app\api\validate\IDMustBePositiveInt;
use app\common\response\RequestResponse;

class User extends BaseController
{
    public function getUserList($page=1,$size=15){
        $userList = UserModel::getUserByPage($page,$size);
        return $userList;
    }
    public function getUserDetail(){
        $uid = Token::getCurrentTokenVar('uid');
        $userDetail = UserModel::get($uid,'addons,album');
        return $userDetail;
    }
    public function getUserDetailById($id){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $userDetail = UserModel::get($id,'addons,album');
        if (!$userDetail ) {
            return RequestResponse::getResponse('请求用户信息不存在','error',400);
        }
        return $userDetail;
    }
    public function countUserMsg(){
        $uid = Token::getCurrentTokenVar('uid');
        $msgCount = model('UserMsg')->where('user_id','=',$uid)->count();
        return $msgCount;
    }

    public function getUserWxInfo(){
        $data = [
            'nickname' => '',
            'head_img' => '',
        ];
        $uid = Token::getCurrentTokenVar('uid');
        $user = UserModel::get($uid);
        if($user->nickname && $user->head_img){
            $data = [
                'nickname' => $user['nickname'],
                'head_img' => $user['head_img'],
            ];
            return RequestResponse::getResponse('','','',$data);
        }else{
            $result = json_decode(Encrypted::encrypt());
            if(!$user->nickname){
                $user->nickname = $result->nickName;
                $data['nickname'] = $result->nickName;
            }
            if(!$user->head_img){
                $imgName = md5(uniqid()).'.jpg';
                $savePath = config('user.images_upload_path').'headimg/'.$imgName;
                $avatarUrl = file_get_contents($result->avatarUrl);
                file_put_contents($savePath,$avatarUrl);
                $imgSrc = config('user.images_web_path').'headimg/'.$imgName;
                $image = new Images();
                $image->save(['url'=>$imgSrc]);
                $user->head_img = $image->id;
                $data['head_img'] = config('domain').$imgSrc;
            }
            $user->save();
            return RequestResponse::getResponse('','','',$data);
        }

    }
}