<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/23 0023
 * Time: 下午 4:26
 */

namespace app\api\behavior;


use app\api\service\Token;

class CheckAuth
{
    public function actionBegin(&$params){
        Token::needExclusiveScope();
    }
}