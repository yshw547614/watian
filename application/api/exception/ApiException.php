<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/15 0015
 * Time: 下午 5:42
 */

namespace app\api\exception;

use Exception;
use think\exception\Handle;

class ApiException extends Handle
{
    public function render(Exception $e)
    {
        if(config('default_return_type')=='json'){
            $result = [
                'msg' => $e->getMessage(),
                'state' => 'error',
                'code' => $e->getCode(),
            ];
            return json($result);
        }else{
            // 其他错误交给系统处理
            return parent::render($e);
        }


    }

}