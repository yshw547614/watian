<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 上午 11:00
 */

namespace app\admin\model;

use app\admin\model\Admin;
use app\common\service\TreeData;
use app\admin\model\AuthGroupAccess;
use think\Db;

class AuthGroup extends BaseModel
{
    public function getRules($data){
        $treeDate = new TreeData();
        $rules = $treeDate->getTreeData($data,0,'pid');
        $htmlRules = $treeDate->getHtmlData($rules);
        return $htmlRules;
    }
    public function del($id){
        $adminModel = new Admin();
        $accessModel = new AuthGroupAccess();
        $groupIds = $accessModel->where('group_id','=',$id)->column('uid');
        $uids = $accessModel->where('group_id','<>',$id)->column('uid');
        $admins = $this->getAdminsByUid($groupIds,$uids);
        Db::startTrans();
        try{
            $this::destroy($id);
            AuthGroupAccess::where('group_id','=',$id)->delete();
            Admin::destroy($admins);
            Db::commit();
            $this->success('删除用户组成功');
        }catch (Exception $e){
            Db::rollback();
            $this->error($e->getMessage());
        }
    }
    public function getAdminsByUid($groupIds,$uid){
        $arr = [];
        if(!empty($groupIds) && is_array($groupIds)){
            foreach ($groupIds as $v){
                !in_array($v,$uid) && $arr[] = $v;
            }
        }
        return $arr;
    }
}