<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/27 0027
 * Time: 下午 2:32
 */

namespace app\admin\model;


class DistanceRule extends Rule
{
    public function checkData($data){
        validate('DistanceRule')->checkData($data);
    }
}