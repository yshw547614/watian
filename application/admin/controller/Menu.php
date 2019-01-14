<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/9 0009
 * Time: 下午 5:34
 */

namespace app\admin\controller;
use app\admin\model\Menu as MenuModel;

class Menu extends BaseController
{
    public function index(){
        $menus=$this->getMenus();
        return $this->fetch('index',['data'=>$menus]);
    }
    public function add(){
        $menuModel = new MenuModel();
        if(request()->isPost()){
            $data = input('post.');
            validate('Menu')->checkData($data);
            $menuModel->addRecord($data,url('index'),'菜单');
        }else{
            $menus=$this->getMenus();
            return $this->fetch('menu',['menus'=>$menus,'type'=>'add']);
        }
    }
    public function edit(){
        $id = request()->param('id');
        $menuModel = new MenuModel();
        $menu = $menuModel->isHasRecord($id);
        if(request()->isPost()){
            $data = input('post.');
            $menuModel->isHasNewData($data,$menu);
            validate('Menu')->checkData($data);
            $menuModel->isUnique(['route'=>$data['route'],'id'=>['neq',$id]],'菜单路由');
            $menuModel->updateRecord($data,url('index'),'菜单',['pid','name','route','icon']);
        }else{
            validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
            $menus = $this->getMenus();
            unset($menus[$id]);
            return $this->fetch('menu',['menu'=>$menu,'menus'=>$menus,'type'=>'edit']);
        }
    }
    public function delete($id){
        $menuModel = new MenuModel();
        validate('IdMustBePositiveInt')->checkData(['id'=>$id]);
        $menuModel->isHasRecord($id);
        $menus = MenuModel::all()->toArray();
        $menuIds = getChildrenIds($id,$menus);
        $menuIds[]=$id;
        $menuModel->delRecord($menuIds,true);
    }
    public function getMenus(){
        $menuModel = new MenuModel();
        $menus = $menuModel->getTreeResult('id','pid');
        return $menus;
    }
}