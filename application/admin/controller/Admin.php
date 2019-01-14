<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/7 0007
 * Time: 上午 11:38
 */

namespace app\admin\controller;

use app\admin\model\Admin AS AdminModel;
use app\admin\model\AuthGroup;
use think\Db;

class Admin extends BaseController
{
    public function index(){
        $admin = AdminModel::with('authGroup')->select();
        return $this->fetch('index',['list'=>$admin]);
    }
    public function add(){
        $adminModel = new AdminModel();
        if(request()->isPost()){
            $data = input('post.');
            validate('Admin')->checkData($data);
            $data['password'] = md5($data['password']);
            $adminModel->add($data);
        }else{
            $groupModel = new AuthGroup();
            $groups = AuthGroup::all(['status'=>1]);
            return $this->fetch('admin',['groups'=>$groups,'type'=>'add']);
        }
    }
    public function edit(){
        $id = request()->param('id');
        $adminModel = new AdminModel();
        $admin = $adminModel->getAdminById($id);
        if(request()->isPost()){
            $data = input('post.');
            validate('Admin')->scene('edit')->checkData($data);
            if(!empty($data['password'])){
                $data['password'] = md5($data['password']);
            }else{
                unset($data['password']);
            }
            $adminModel->checkNewData($data,$admin);
            $adminModel->edit($data);
        }else{
            validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
            $groups = AuthGroup::all(['status'=>1]);
            return $this->fetch('admin',['groups'=>$groups,'admin'=>$admin,'type'=>'edit']);
        }
    }
    public function del($id){
        $adminModel = new AdminModel();
        validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
        $adminModel->isHasRecord($id);
        $adminModel->del($id);
    }
}