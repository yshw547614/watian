<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/7 0007
 * Time: 上午 9:38
 */

namespace app\api\model;


use think\Model;
use app\common\model\AfterServiceProduct as AfterServiceProductCommon;

class AfterServiceProduct extends Model
{
    use AfterServiceProductCommon;
    public function setImagesAttr($value){
        if($value){
            return serialize($value);
        }
    }
}