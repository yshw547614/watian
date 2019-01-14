<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/10 0010
 * Time: 下午 2:29
 */

namespace app\api\service;
use think\Exception;
use think\Loader;
use think\Cache;

Loader::import('WxEncrypted.wxBizDataCrypt',EXTEND_PATH);

class Encrypted
{
    public static function encrypt(){
        $data = input('post.');
        $appid = config('wx.app_id');
        $token = request()->header('token');
        $wxResult = json_decode(Cache::get($token));
        $pc = new \WXBizDataCrypt($appid, $wxResult->session_key);
        $errCode = $pc->decryptData($data['encryptedData'], $data['iv'], $result);

        if ($errCode == 0) {
            return $result;
        } else {
            throw new Exception('获取用户信息失败',$errCode);
        }
    }
}