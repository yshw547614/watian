<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/4 0004
 * Time: 下午 3:01
 */

namespace app\api\validate;

use think\Exception;

class AfterService extends BaseValidate
{
    protected $rule = [
        'order_products' => 'require|checkOrderProducts'
    ];

    protected $singleRule = [
        'order_product_id' => 'require|isPositiveInteger:退款商品参数不正确',
        'reason' => 'require|isPositiveInteger:请选择退款原因',
        'describe' => 'max:255',
        'images' => 'array',

    ];
    protected $singleMsg = [
        'order_product_id.require' => '请选择退款商品',
        'reason.require' => '请选择退款原因',
        'describe.max' => '退款说明不能超过255个字符',
        'images.array' => '图片格式不正确'
    ];
    protected function checkOrderProducts($values)
    {
        if(empty($values)){
            throw new Exception('申请列表不能为空');
        }
        foreach ($values as $value)
        {
            $this->checkOrderProduct($value);
        }
        return true;
    }

    private function checkOrderProduct($value)
    {
        $this->rule = $this->singleRule;
        $this->message = $this->singleMsg;
        $result = $this->check($value);
        if(!$result){
            throw new Exception($this->getError());
        }
        return true;
    }

    protected function isPositiveInteger($value, $rule='', $data='', $field='',$describe='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }else{
            return $rule;
        }

    }
}