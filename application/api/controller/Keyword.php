<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/25
 * Time: 0:59
 */

namespace app\api\controller;


use app\api\service\Token;
use app\common\response\RequestResponse;

class Keyword extends BaseController
{
    public function getKeyword($size=6){
        $list = model('Keyword')->order('id desc')->limit($size)->select();
        if($list){
            $list = array_column($list->toArray(),'title');
        }
        return RequestResponse::getResponse('','','',$list);
    }
    public function getUserKeyword($size=0){
        $uid = Token::getCurrentUid();
        $list = model('UserKeyword')->where('user_id',$uid)
            ->order('update_time desc')->limit($size)->column('keyword');
        return RequestResponse::getResponse('','','',$list);
    }
}