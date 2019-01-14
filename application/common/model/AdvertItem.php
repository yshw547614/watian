<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/28 0028
 * Time: 下午 2:51
 */

namespace app\common\model;

trait AdvertItem
{
    public function getImgUrlAttr($value){
        $imgPath = config('domain');
        return $imgPath.$value;
    }
}