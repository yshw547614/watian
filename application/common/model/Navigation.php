<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/27 0027
 * Time: 上午 10:59
 */

namespace app\common\model;


trait Navigation
{
    public function getIconAttr($value){
        $imgPath = config('domain');
        return $imgPath.$value;
    }
}