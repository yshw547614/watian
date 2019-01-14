<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/11 0011
 * Time: 上午 10:19
 */

namespace app\admin\model;


class Gift extends BaseModel
{
    protected $autoWriteTimestamp = true;

    public function getImageAttr($value){
        $imgUploadPath = config('gift.images_web_path');
        return $imgUploadPath.$value;
    }
}