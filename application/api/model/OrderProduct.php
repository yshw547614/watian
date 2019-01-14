<?php

namespace app\api\model;

class OrderProduct extends BaseModel
{
    protected $hidden = ['product_sn'];

    public function product(){
        return $this->belongsTo('Product','product_id','id');
    }
    public function setThumbImgAttr($value)
    {
        $imgPath = config('domain');
        return str_replace($imgPath,'',$value);
    }
    public function getThumbImgAttr($value)
    {
        $imgPath = config('domain');
        return $imgPath.$value;
    }

    public function productComment(){
        return $this->hasOne('ProductComment','order_product_id','id');
    }
}
