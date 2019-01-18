<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 下午 5:40
 */

namespace app\admin\controller;


class Index extends BaseController
{
    public function index(){
        return view();
    }

    public function main(){
        return $this->fetch();
    }
}