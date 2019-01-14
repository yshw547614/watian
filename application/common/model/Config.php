<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/27 0027
 * Time: 下午 10:39
 */

namespace app\common\model;


use think\Model;

class Config extends Model
{
    public static function getFreightFree(){
        $freightFree = self::where('name','freight_free')->value('value');
        if($freightFree){
            $freightFree = (float)$freightFree;
        }else{
            $freightFree = 0;
        }
        return $freightFree;
    }
}