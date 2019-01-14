<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/14 0014
 * Time: 下午 4:13
 */

namespace app\api\controller;

use app\api\model\User;
use app\api\service\UserEdit as UserEditService;

class UserEdit
{
    public function editHeadImg(){
        return UserEditService::editHeadImg();
    }

    public function editUser(){
        return UserEditService::editUser();
    }

    public function editUserAddons(){
        return UserEditService::editUserAddons();
    }

}