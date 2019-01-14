<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/6 0006
 * Time: 下午 7:06
 */

namespace app\api\model;

class ProductAddons extends BaseModel
{
    protected $hidden = ['id','product_id'];
    public function getMainImgAttr($value){
        return $this->getImgsArr($value);
    }
    public function getTopicImgAttr($value){
        return $this->getImgsArr($value);
    }
    public function getPropertyAttr($value){
        return $this->getImgsArr($value);
    }
    public function getServiceAttr($value){
        return $this->getImgsArr($value);
    }
    public function getServiceExplainAttr($value){
        $arr = [];
        if(!empty($value)){
            $arr = explode("||",$value);
            return $arr;
        }

    }
    public function getImgsArr($imgsStr){
        $str = rtrim($imgsStr,'###');
        $arr = explode('###',$str);
        array_walk($arr,[$this,'imgPrefix']);
        return $arr;
    }
    public function imgPrefix(&$imgName,$key){
        $webPath = config('domain');
        $imgName = $webPath.$imgName;
    }
}