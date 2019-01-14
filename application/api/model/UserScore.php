<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/27 0027
 * Time: 下午 3:11
 */

namespace app\api\model;

use think\Model;
use app\api\model\User;

class UserScore extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    public static function createUserScore($ruleId,$uid){
        $rule = ScoreRule::get($ruleId);
        $data = ['user_id'=>$uid,'rule_id'=>$rule['id'],'score'=>$rule['score']];
        self::create($data);
        User::where('id',$uid)->setInc('score',$rule['score']);
    }
}