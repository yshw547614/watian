<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/26 0026
 * Time: 下午 6:44
 */

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Menu;
use app\common\service\TreeData;

class BaseController extends Controller
{
    public function _initialize()
    {
        $treeData = new TreeData();
        $menus = Menu::all()->toArray();
        $treeMenu = $treeData->channelList($menus);
        $this->assign('navmenus',$treeMenu);
    }
}