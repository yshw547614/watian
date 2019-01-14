<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/8 0008
 * Time: 下午 2:28
 */

namespace app\api\controller;

use app\api\service\Token;
use app\api\model\UserTags;

class Tags extends BaseController
{
    public function getUserTags(){
        $uid = Token::getCurrentTokenVar('uid');
        $userTags = UserTags::all(['user_id'=>$uid]);
    }
    public function getUserTagsByType(){

    }
    public function editUserTags(){

    }
}