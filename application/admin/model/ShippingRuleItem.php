<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/2
 * Time: 17:32
 */

namespace app\admin\model;


class ShippingRuleItem extends BaseModel
{
    public function getAreaStrAttr($value,$data){
        $arr = explode(',',$data['exc_region']);
        $regionArr = model('Region')->where('id','in',$arr)->column('name');
        return implode(',',$regionArr);
    }
}