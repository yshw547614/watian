<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/21 0021
 * Time: 上午 10:48
 */

namespace app\api\controller;

use app\api\model\DegreeImage;

class Degree extends BaseController
{
    public function uploadImg(){
        $degreeImage = new DegreeImage();
        return $degreeImage->change();
    }

    public function del($id){
        $degreeImage = new DegreeImage();
        return $degreeImage->del($id);
    }
    public function upDateRank(){
        $degreeImage = new DegreeImage();
        return $degreeImage->updateRank();
    }
}