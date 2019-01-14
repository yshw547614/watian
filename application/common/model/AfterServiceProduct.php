<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/10 0010
 * Time: 下午 2:22
 */

namespace app\common\model;


trait AfterServiceProduct
{
    public function orderProduct(){
        return $this->belongsTo('OrderProduct','order_product_id','id');
    }
    public function getImagesAttr($value){
        if($value){
            $imageIds = unserialize($value);
            $images = model('Images')->where('id','in',$imageIds)->column('url');
            array_walk($images,[$this,'setImgPrefix']);
            return $images;
        }
    }
    public function setImgPrefix(&$image,$key){
        $image =  config('domain').$image;
    }
    public function getReasonAttr($value){
        $status = config('return.reason');
        $result = $status[$value-1];
        if(isset($result)){
            return $result;
        }
    }
}