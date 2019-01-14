<?php
/**

 * Date: 2017/3/19
 * Time: 3:00
 */

namespace app\api\behavior;


use app\api\service\Token;
use think\Response;

class CORS
{
    public function appInit(&$params)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: token,Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: POST,GET');
        header("Content-type:text/html;charset=UTF-8");
        if(request()->isOptions()){
            exit();
        }
    }

}