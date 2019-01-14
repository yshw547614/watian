<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/16 0016
 * Time: 下午 3:23
 */

namespace app\common\model;


use app\api\model\Images;

trait ProductComment
{
    public function getImagesAttr($value){
        $images = [];
        $arr = unserialize($value);
        if(!empty($arr) && is_array($arr)){
            $images = Images::where('id','in',$arr)->select()->hidden(['id']);
        }
        if(!empty($images)){
            $images = $images->toArray();
            $images = array_column($images,'url');
        }
        return $images;
    }
}