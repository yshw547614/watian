<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 下午 3:06
 */

namespace app\admin\validate;

use app\common\validate\BaseValidate as CommentBaseValidate;
use app\common\response\RequestResponse;
use think\Exception;

class BaseValidate extends CommentBaseValidate
{
    public function checkData($postData,$isAjax=false){
        $flag = $this->check($postData);
        if(!$flag){
            if($isAjax){
                $msg = is_array($this->error)?implode(';',$this->error):$this->error;
                throw new Exception($msg,406);
            }else{
                $this->error($this->error);
            }
        }else{
            return true;
        }
    }
    public function checkout(){
        $params = request()->param();
        if (!$this->check($params)) {
            $msg = is_array($this->error)?implode(';',$this->error):$this->error;
            return RequestResponse::getResponse($msg,'error',400);
        }
    }
}