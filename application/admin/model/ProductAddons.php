<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/18 0018
 * Time: 下午 3:57
 */

namespace app\admin\model;


class ProductAddons extends BaseModel
{
    public function updateImg($data){
        $flag = false;
        $addon = self::get(['product_id'=>$data['id']]);
        $addon->topic_img = str_replace($data['fileName'].'###','',$addon['topic_img']);
        $addon->save() && $flag = true;
        return $flag;
    }

    public function getThemeImgAttr($value,$data){
        if($data['topic_img']){
            return $this->getImagesArr($data['topic_img']);
        }
    }

    public function getDetailImgAttr($value,$data){
        if($data['main_img']){
            return $this->getImagesArr($data['main_img']);
        }
    }

    public function getPropertyImgAttr($value,$data){
        if($data['property']){
            return $this->getImagesArr($data['property']);
        }
    }
    public function getImagesArr($imgStr){
        $imgArr = explode('###',rtrim($imgStr,'###'));
        is_array($imgArr) && array_walk($imgArr,[$this,'prefixImg']);
        return $imgArr;
    }

    public function prefixImg(&$imgUrl,$key){
        $imgUrl = config('product.images_web_path').$imgUrl;
    }
}