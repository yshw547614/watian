<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/28 0028
 * Time: 下午 8:06
 */

namespace app\api\model;


class UserDistanceConsume extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    public static function incDistanceByConsume($uid,$ruleId){
        $lastIncreaseTime = self::where(['user_id'=>$uid])->
        order('id desc')->limit(1)->value('create_time');
        $totalConsume = UserMoney::where('user_id',$uid)->
        where('create_time','>',$lastIncreaseTime)->
        where('type',1)->sum('money');
        $repeat = floor($totalConsume/10000);
        self::addUserDistanceConsume(2,$uid,$repeat);
    }

    public static function addUserDistanceConsume($ruleId,$uid,$repeat){
        $rule = DistanceRule::get($ruleId);
        $data =[
            'user_id' => $uid,
            'kilometre' => $repeat*$rule['kilometre'],
        ];
        self::create($data);
    }
}