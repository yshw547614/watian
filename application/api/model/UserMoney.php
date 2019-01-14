<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/28 0028
 * Time: 下午 4:33
 */

namespace app\api\model;


class UserMoney extends BaseModel
{
    protected $autoWriteTimestamp = true;

    public static function createUserMoney($uid,$money,$explain){
        $data = [
            'user_id' => $uid,
            'money' =>$money,
            'type' => 1,
            'explain' => $explain,
        ];
        self::create($data);
    }
}