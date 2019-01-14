<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/15 0015
 * Time: 下午 3:03
 */

namespace app\admin\model;


class ProductServiceTemplate extends BaseModel
{
    public function getServiceIdsAttr($value){
        if($value){
            return unserialize($value);
        }
    }

    public function items(){
        return $this->hasMany('ProductService','template_id','id');
    }
    public function products(){
        return $this->hasMany('Product','service_template_id','id');
    }
}