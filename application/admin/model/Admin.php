<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 上午 11:03
 */

namespace app\admin\model;

use think\Db;
use think\Exception;
use think\Log;
use app\admin\model\AuthGroupAccess;

class Admin extends BaseModel
{
    public function authGroupAccess(){
        return $this->hasMany('AuthGroupAccess','uid','id');
    }
    public function authGroup(){
        return $this->belongsToMany('AuthGroup','auth_group_access','group_id','uid');
    }
    public function add($data){
        $accessModel = new AuthGroupAccess();
        Db::startTrans();
        try{
            $this->isUpdate(false)->allowField(['name','password','status'])->save($data);
            $accessModel->add($this->id,$data['groups']);
            Db::commit();
            $this->success('添加用户成功',url('index'));
        }catch (Exception $e){
            Db::rollback();
            Log::error($e);
            $this->error('添加用户失败');
        }
    }

    public function edit($data){
        $flag = false;
        $accessModel = new AuthGroupAccess();
        $this->isUpdate(true)->allowField(['name','password','status'])->save($data) && $flag = true;
        $accessModel->edit($data) && $flag = true;
        if($flag){
            $this->success('修改用户成功',url('index'));
        }else{
            $this->error('修改用户资料失败');
        }
    }

    public function del($id){
        Db::startTrans();
        try{
            $this::destroy($id);
            AuthGroupAccess::where('uid','=',$id)->delete();
            Db::commit();
            $this->success('删除用户成功');
        }catch (Exception $e){
            Db::rollback();
            $this->error($e->getMessage());
        }

    }
    public function checkNewData($postData,$dbData){
        $flag = false;
        $accessModel = new AuthGroupAccess();
        if(is_array($postData)){
            foreach ($postData as $key =>$value){
                if($key == 'groups'){
                    $accessModel->isChangeGroupId($value,$dbData['group_ids']) && $flag = true;
                }else{
                    $value != $dbData[$key] && $flag = true;
                }
            }
        }
        !$flag && $this->error('没有数据更新');
    }
    public function getAdminById($id){
        $admin = $this::get($id,'authGroup');
        if($admin){
            $admin['group_ids'] = $this->numericArray($admin['auth_group'],'id');
            unset($admin['auth_group']);
            return $admin;
        }else{
            $this->error('操作的记录不存在');
        }

    }
    public function groups($uid,$data){
        $groups = [];
        $accessList = AuthGroupAccess::all(['uid'=>$uid]);
        foreach($data as $value){
            !$this->isInGroupAccess($uid,$value,$accessList) && $groups[]= ['uid'=>$uid,'group_id'=>$value];
        }
        return $groups;
    }

    public function isInGroupAccess($uid,$group_id,$accessList){
        $flag = false;
        if(is_array($accessList)){
            foreach ($accessList as $value){
                if($value['uid']==$uid && $value['group_id']==$group_id){
                    $flag = true;
                    break;
                }
            }
        }
        return $flag;
    }

}