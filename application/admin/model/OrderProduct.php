<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/7
 * Time: 16:53
 */

namespace app\admin\model;

class OrderProduct extends BaseModel
{
    public function service(){
        return $this->hasOne('AfterService','order_product_id','id');
    }

    public function product(){
        return $this->belongsTo('Product','product_id','id');
    }
    public function getIsReturnAttr($value){
        $status = [
            '0' => '正常',
            '1' => '已退货'
        ];
        if(isset($status[$value])){
            return $status[$value];
        }
    }
    public function goodsOrder(){
        return $this->belongsTo('Order','order_id','id');
    }
    public function getThumbImgAttr($value){
        if($value){
            return config('product.images_web_path').$value;
        }
    }
}