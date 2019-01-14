<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/28 0028
 * Time: 下午 2:55
 */

namespace app\common\model;


trait Category
{
    public function getTopicImgAttr($value){
        $imgPath = config('domain');
        return $imgPath.$value;
    }
    public function getIconAttr($value){
        $imgPath = config('domain');
        return $imgPath.$value;
    }
}