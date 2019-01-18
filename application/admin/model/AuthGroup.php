<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 上午 11:00
 */

namespace app\admin\model;

use app\common\service\TreeData;
use think\Db;

class AuthGroup extends BaseModel
{
    public function getRules($data){
        $treeDate = new TreeData();
        $rules = $treeDate->getTreeData($data,0,'pid');
        $htmlRules = $treeDate->getHtmlData($rules);
        return $htmlRules;
    }
}