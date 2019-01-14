<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/15
 * Time: 23:24
 */

namespace app\api\model;


class ProductStore extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public function product(){
        return $this->belongsTo('Product','product_id','id');
    }
}