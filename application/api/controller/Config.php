<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/14 0014
 * Time: 下午 2:44
 */

namespace app\api\controller;


use app\common\response\RequestResponse;
use app\common\service\JsonConfig;

class Config extends BaseController
{
    public function attentionWechatWord(){
        $content = JsonConfig::get('wechat_word.content');
        return RequestResponse::getResponse('','','',$content);
    }

    public function downlowAppWord(){
        $content = JsonConfig::get('app_word.content');
        return RequestResponse::getResponse('','','',$content);
    }
}