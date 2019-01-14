<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/3
 * Time: 19:04
 */

namespace app\admin\model;


class FreightConfig extends BaseModel
{
    public function region(){
        return $this->belongsToMany('Region','freight_region','region_id','config_id');
    }
}