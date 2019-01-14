<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/7
 * Time: 16:56
 */
namespace app\common\model;

trait Order{
    public function snapItems(){
        return $this->hasMany('OrderProduct','order_id','id');
    }
    public function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode(($value));
    }
}