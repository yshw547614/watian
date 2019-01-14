<?php
/**

 * Date: 2017/2/25
 * Time: 17:21
 */

namespace app\api\service;
use app\api\model\ThirdApp;
use app\common\response\RequestResponse;
use think\Exception;

class AppToken extends Token
{
    public function get($ac, $se)
    {
        $app = ThirdApp::check($ac, $se);
        if(!$app)
        {
            throw new Exception('服务器缓存异常',10004);
        }
        else{
            $scope = $app->scope;
            $uid = $app->id;
            $values = [
                'scope' => $scope,
                'uid' => $uid
            ];
            $token = $this->saveToCache($values);
            return $token;
        }
    }
    
    private function saveToCache($values){
        $token = self::generateToken();
        $expire_in = config('user.token_expire_in');
        $result = cache($token, json_encode($values), $expire_in);
        if(!$result){
            throw new Exception('服务器缓存异常',502);
        }
        return $token;
    }
}