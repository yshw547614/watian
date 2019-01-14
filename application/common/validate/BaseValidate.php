<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 下午 3:06
 */

namespace app\common\validate;

use app\api\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;
use traits\controller\Jump;

class BaseValidate extends Validate
{
    use Jump;

    public function checkUp(){
        //必须设置contetn-type:application/json
        $request = Request::instance();
        $params = $request->param();
        $params['token'] = $request->header('token');
        if (!$this->check($params)) {
            $msg = is_array($this->error)?implode(';',$this->error):$this->error;
            throw new Exception($msg);
        }
        return true;
    }
    /**
     * @param array $arrays 通常传入request.post变量数组
     * @return array 按照规则key过滤后的变量数组
     * @throws ParameterException
     */
    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id', $arrays) || array_key_exists('uid', $arrays)) {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new Exception('参数中包含有非法的参数名user_id或者uid',403);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
    protected function isPositiveInteger($value, $rule='', $data='', $field='',$describe='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }else{
            return $describe . '必须是正整数';
        }

    }

    protected function isInteger($value, $rule='', $data='', $field='',$describe=''){
        if (is_numeric($value) && is_int($value + 0)) {
            return true;
        }else{
            return $describe . '必须是整数';
        }
    }
    protected function isNotEmpty($value, $rule='', $data='', $field='',$describe='')
    {
        if (empty(trim($value))) {
            return $describe . '不允许为空';
        } else {
            return true;
        }
    }

    //没有使用TP的正则验证，集中在一处方便以后修改
    //不推荐使用正则，因为复用性太差
    //手机号的验证规则
    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}