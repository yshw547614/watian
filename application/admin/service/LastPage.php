<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/12 0012
 * Time: 下午 3:38
 */

namespace app\admin\service;


use think\Cache;

class LastPage
{
    public static function setPage($page){
        Cache::set('page',$page,7200);
    }
}