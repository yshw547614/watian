<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/11 0011
 * Time: 下午 8:24
 */

namespace app\admin\model;


class User extends BaseModel
{
    public function getHeadImgAttr($value){
        if($value){
            $imgUrl = Images::where('id',$value)->value('url');
            if($imgUrl){
                return $imgUrl;
            }

        }
    }
}