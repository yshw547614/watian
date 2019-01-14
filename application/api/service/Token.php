<?php
/**
 * Date: 2017/2/24
 * Time: 17:18
 */

namespace app\api\service;


use app\api\enum\ScopeEnum;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{

    // 生成令牌
    public static function generateToken()
    {
        $randChar = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('user.token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }

    // 用户专有权限
    public static function needExclusiveScope()
    {
		$scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if($scope == ScopeEnum::User) {
                return true;
            }else{
                throw new Exception('权限不够',403);
            }
        }else{
            throw new Exception('Token已过期或无效Token',401);
        }
    }
    
    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars){
            throw new Exception('Token已过期或无效Token',401);
        }
        if(!is_array($vars)){
            $vars = json_decode($vars, true);
        }
        if(!array_key_exists($key, $vars)){
            throw new Exception('尝试获取的Token变量并不存在',405);
        }else{
            return $vars[$key];
        }
    }
    


    /**
     * 当需要获取全局UID时，应当调用此方法
     *而不应当自己解析UID
     *
     */
    public static function getCurrentUid()
    {
		$uid = self::getCurrentTokenVar('uid');
		return $uid;
    }

    /**
     * 检查操作UID是否合法
     * @param $checkedUID
     * @return bool
     * @throws Exception
     */
    public static function isValidOperate($checkedUID)
    {
        if(!$checkedUID){
            throw new Exception('检查UID时必须传入一个被检查的UID',406);
        }
        $uid = self::getCurrentUid();
        if($uid == $checkedUID){
            return true;
        }
        return false;
    }

    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }else{
            return false;
        }
    }
}