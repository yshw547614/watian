<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/19 0019
 * Time: 下午 4:20
 */

namespace app\api\controller;

use app\api\model\UserNameProve;

class NameProve extends BaseController
{
    public function uploadImg(){
        $model = new UserNameProve();
        return $model->uploadIdentityImg();
    }
    public function deleteImg(){
        $model = new UserNameProve();
        return $model->deleteIdentityImg();
    }
    public function edit(){
        $model = new UserNameProve();
        return $model->editIdentify();
    }

}