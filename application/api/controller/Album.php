<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/14 0014
 * Time: 下午 2:31
 */

namespace app\api\controller;
use app\api\model\UserAlbum;

class Album extends BaseController
{

    public function update(){
        $userAlbum = new UserAlbum();
        return $userAlbum->change();
    }
    public function del($id){
        $userAlbum = new UserAlbum();
        return $userAlbum->del($id);
    }
    public function upDateRank(){
        $userAlbum = new UserAlbum();
        return $userAlbum->updateRank();
    }
}