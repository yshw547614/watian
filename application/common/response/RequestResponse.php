<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/9
 * Time: 14:55
 */

namespace app\common\response;

class RequestResponse
{
    protected static $msg = 'ok';
    protected static $state = 'success';
    protected static $code = 200;

    public static function getResponse($msg='ok',$state='success',$code=200,$data=null){
        $res = [];
        $res['msg'] = $msg?$msg:self::$msg;
        $res['state'] = $state?$state:self::$state;
        $res['code'] = $code?$code:self::$code;
        $data && $res['data'] = $data;
        return $res;
    }

    public static function getResponseByResult($result=true,$msg='ok',$state='success',$code=200,$data=[]){
        if($result){
            return self::getResponse($msg,$state,$code,$data);
        }else{
            return self::getResponse('服务器错误','error',502);
        }
    }
}