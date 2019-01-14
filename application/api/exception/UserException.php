<?php
/**

 * Date: 2017/2/25
 * Time: 16:18
 */

namespace app\api\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}