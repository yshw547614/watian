<?php

namespace app\common\model;

/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/28 0028
 * Time: 下午 2:00
 */
trait Product
{

    public function category(){
        return $this->belongsTo('Category','category_id','id');
    }
    public function addons(){
        return $this->hasOne('ProductAddons','product_id','id');
    }
}