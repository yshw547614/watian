<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/19 0019
 * Time: 下午 2:09
 */

namespace app\api\controller;


use app\common\response\RequestResponse;

class Slogan extends BaseController
{
    public function getList(){
        $list = model('Slogan')->field('title,link')->select();
        return RequestResponse::getResponse('','','',$list);
    }
}