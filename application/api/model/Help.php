<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/31 0031
 * Time: 上午 9:32
 */

namespace app\api\model;


use think\Model;

class Help extends Model
{
    public function category(){
        return $this->belongsTo('HelpType','type_id','id');
    }
    public function getCategoryTitleAttr($value,$data){
        $title = model('HelpType')->where('id',$data['type_id'])->value('title');
        return $title;
    }
}