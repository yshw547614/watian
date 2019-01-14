<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/7 0007
 * Time: 上午 11:50
 */

namespace app\admin\service;
use app\admin\model\Admin;

class Login
{
    public function login($data){
        $adminModel = new Admin();
        $admin = Admin::where('name',$data['name'])->find();
        if($admin && $admin['password']==md5($data['password'])){
            session('user',[
                'id' => $admin['id'],
                'name' => $admin['name']
            ]);
            return true;
        }else{
            return false;
        }
    }
}