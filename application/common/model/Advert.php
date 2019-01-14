<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/28 0028
 * Time: 下午 2:47
 */

namespace app\common\model;


trait Advert
{
    public function items(){
        return $this->hasMany('AdvertItem','advert_id','id');
    }
}