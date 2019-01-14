<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/12 0012
 * Time: 下午 2:39
 */

namespace app\admin\model;


class Help extends BaseModel
{
    protected $autoWriteTimestamp = true;

    public function type(){
        return $this->belongsTo('HelpType','type_id','id');
    }
}