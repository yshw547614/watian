<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/2
 * Time: 17:31
 */

namespace app\admin\model;


class ShippingRule extends BaseModel
{
    public function getStatusChAttr($value,$data){
        $status = [
            '-1' => '已失效',
            '0' =>'未生效',
            '1' => '生效中'
        ];
        if(isset($status[$data['status']])){
            return $status[$data['status']];
        }

    }
    public function getStartTimeAttr($value,$data){
        if($value){
            return date('Y-m-d H:i:s',$value);
        }
    }
    public function getEndTimeAttr($value){
        if($value){
            return date('Y-m-d H:i:s',$value);
        }
    }
}