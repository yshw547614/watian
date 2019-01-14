<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/10/8 0008
 * Time: 上午 11:16
 */

namespace app\api\model;


use think\Model;

class ShippingRuleItem extends Model
{
    public function rule(){
        return $this->belongsTo('ShippingRule','rule_id','id');
    }
}