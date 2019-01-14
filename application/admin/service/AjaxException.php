<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/23 0023
 * Time: 上午 11:26
 */

namespace app\admin\service;

use Exception;
use think\exception\Handle;

class AjaxException extends Handle
{
    public function render(Exception $e)
    {
        if(request()->isAjax()){
            $result = [
                'msg' => $e->getMessage(),
                'state' => 'error',
                'code' => $e->getCode(),
            ];
            return json($result);
        }

        // 其他错误交给系统处理
        return parent::render($e);
    }

}