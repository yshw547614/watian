<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 上午 11:13
 */

namespace app\admin\behavior;
use app\admin\service\Auth;
use think\Request;
use \traits\controller\Jump;

class CheckAuth
{
    use Jump;

    public function run(&$params){
        $this->checkLogin();
        $this->checkAuth();
    }
    public function checkLogin(){
        $controller = strtolower(request()->controller());
        $flag = $controller == 'login' ? true : false;
        if(!$flag && !session('user.id')){
            $this->redirect(url('Login/login'));
        }
    }
    public function checkAuth(){
        $auth=new Auth();
        $request=Request::instance();
        $con=$request->controller();
        $action=$request->action();
        $name=strtolower($con.'/'.$action);
        $result = $auth->check($name,session('user.id'));
        if(!$result){
            //$this->redirect(url('Index/index'));
        }
    }
}