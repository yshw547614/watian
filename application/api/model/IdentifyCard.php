<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/27 0027
 * Time: 下午 5:16
 */

namespace app\api\model;


class IdentifyCard extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public function getObverseImgAttr($value){
        $image = Images::get($value);
        return $image;
    }
    public function getOppositeImgAttr($value){
        $image = Images::get($value);
        return $image;
    }
}