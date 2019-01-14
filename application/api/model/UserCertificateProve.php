<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/21 0021
 * Time: 下午 2:33
 */

namespace app\api\model;

use app\api\model\CertificateImage;
use app\api\service\Token;

class UserCertificateProve extends Picture
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time','update_time'];
    public function image(){
        return $this->hasMany('CertificateImage','certificate_id','id');
    }
    public function getImagesAttr($value){
        $list = [];
        $arr = unserialize($value);
        $savePath = config('domain').config('user.image_web_path');
        if(is_array($arr)){
            foreach ($arr as $img){
                $tmp['name'] = $img;
                $tmp['src'] = $savePath.$img;
                $list[] = $tmp;
            }
        }
        return $list;
    }
    public function setImagesAttr($value,$data){
        return serialize($value);
    }
}