<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 上午 11:01
 */

namespace app\admin\model;

class AuthGroupAccess extends BaseModel
{
    public function add($uid,$groupIds){
        $flag = false;
        foreach ($groupIds as $groupId){
            $data[] = ['uid'=>$uid,'group_id'=>$groupId];
        }
        $this->isUpdate(false)->allowField(true)->saveAll($data) && $flag = true;
        return $flag;
    }
    public function edit($data){
        $flag = false;
        if($data['groups']){
            $this->where('uid','=',$data['id'])->delete();
            $this->add($data['id'],$data['groups']) && $flag = true;
        }
        return $flag;
    }
    public function isChangeGroupId($postGroupIds,$dbGroupIds){
        $flag = false;
        foreach ($postGroupIds as $postGroupId){
            (!in_array($postGroupId,$dbGroupIds)) && $flag = true;
        }
        foreach ($dbGroupIds as $dbGroupId){
            (!in_array($dbGroupId,$postGroupIds)) && $flag = true;
        }
        return $flag;
    }

}