<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/28 0028
 * Time: 下午 3:56
 */

namespace app\api\model;


class UserDistance extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    public static function createUserDistance($uid,$ruleId){
        $rule = DistanceRule::get($ruleId);
        $data = ['user_id'=>$uid,'distance_id'=>$rule['id'],'kilometre'=>$rule['kilometre']];
        self::create($data);
        User::where('id',$uid)->setInc('kilometre',$rule['kilometre']);
    }
}