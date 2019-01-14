<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/3
 * Time: 19:05
 */

namespace app\admin\model;


class FreightTemplate extends BaseModel
{
    public function config(){
        return $this->hasMany('FreightConfig','template_id','id');
    }
    public function getUnitNameAttr($value,$data){
        $unitName = ['件数（件）','重量（克）','体积（m³）'];
        return $unitName[$data['type']];
    }

}