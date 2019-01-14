<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/23 0023
 * Time: 下午 3:14
 */

namespace app\api\model;


use think\Model;

class Images extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    protected $hidden = ['create_time'];

    public function getUrlAttr($value){
        if($value){
            $domain = config('domain');
            return $domain.$value;
        }
    }
}