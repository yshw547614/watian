<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/10 0010
 * Time: 下午 2:09
 */

namespace app\common\model;


trait AfterService
{
    public function afterServiceProduct(){
        return $this->hasMany('AfterServiceProduct','after_service_id','id');
    }
    public function getDeliveryAttr($value){
        if($value){
            $arr = unserialize($value);
            $data['odd_number'] = isset($arr['odd_number'])?$arr['odd_number']:'';
            $express = model('Express')->get($arr['express_id']);
            if($express){
                $data['express_name'] = $express['title'];
                $data['express_code'] = $express['code'];
                $data['express_type'] = $express['type'];
            }
            return $data;
        }
    }
    public function getAfterService(){

        $query = model('AfterService')->with(
            [
                'AfterServiceProduct' => function($query){
                    $query->with(
                        [
                            'OrderProduct' => function($query){
                                $orderProductField = [
                                    'id',
                                    'product_id',
                                    'product_sn',
                                    'name',
                                    'thumb_img',
                                    'original_price',
                                    'price',
                                    'total_price',
                                    'count',
                                    'nation'
                                ];
                                $query->field($orderProductField);
                            }
                        ]
                    );
                }
            ]
        );
        return $query;
    }
}