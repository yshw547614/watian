<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/7 0007
 * Time: 上午 11:38
 */

namespace app\admin\controller;

use app\common\response\RequestResponse;
use app\common\service\TreeData;

class Admin extends BaseController
{
    /**
     * 管理员列表模板展示
     * @return mixed
     */
    public function index(){
        return $this->fetch();
    }

    /**
     * 添加、编辑管理员信息模板展示
     * @return mixed
     */
    public function edit(){
        return $this->fetch();
    }

    public function pass(){
        return $this->fetch();
    }
    /**
     * 管理员个人信息模板展示
     * @return mixed
     */
    public function detail(){
        return $this->fetch();
    }

    /**
     * 获取当前登录管理员信息
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getAdmin(){
        $data = model('Admin')->where('id',session('user.id'))->find();
        $group = model('AuthGroup')->where('id',$data['group_id'])->find();
        $rules = model('AuthRule')->field('id,pid,title')->where('id','in',$group['rules'])->select()->toArray();
        $treeObj = new TreeData();
        $ruleTree = $treeObj->getTreeData($rules);
        $ruleHtmlTree = $treeObj->getHtmlData($ruleTree);
        $data['group_name'] = $group['title'];
        $data['rules'] = $ruleHtmlTree;
        return $data;
    }
    /**
     * 获取指定id管理员信息
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getOneData(){
        $id = request()->param('id');
        $data = model('Admin')->where('id',$id)->find();
        return $data;
    }

    /**
     * 获取管理员列表
     * @return \think\response\Json
     */
    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $list = model('Admin')->where('name','neq','admin')->paginate($limit)->toArray();
        $dataArr = $this->getAuthGroup($list['data']);
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'count' => $list['total'],
            'data' => $dataArr,
        ];
        return json($data);
    }

    /**
     * 获取管理员对应的用户组名称
     * @param $rows
     * @return mixed
     */
    public function getAuthGroup($rows){
        $groupIds = array_column($rows,'group_id');
        $groups = model('AuthGroup')->field('id,title')->where('id','in',$groupIds)->select()->toArray();
        foreach ($rows as &$row){
            foreach ($groups as $group){
                if($row['group_id'] == $group['id']){
                    $row['group_name'] = $group['title'];
                }
            }
        }
        return $rows;
    }

    /**
     * 查询用户组列表
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getGroup(){
        $data = model('AuthGroup')->field('id,title')->select();
        return $data;
    }

    /**
     * 保存数据，添加管理员、编辑管理员信息
     * @return array
     */
    public function saveData(){
        $post = input('post.');
        $isUpdate = isset($post['id'])?true:false;
        $post['status'] = $post['status']=='on'?1:0;
        if($post['password']){
            $post['password'] = md5($post['password']);
        }
        model('Admin')->isUpdate($isUpdate)->save($post);
        return RequestResponse::getResponse();
    }

    /**
     * 修改密码
     * @return array
     */
    public function updatePass(){
        $post = input('post.');
        $id = session('user.id');
        $row = model('Admin')->where('id',$id)->find();
        if(md5($post['old_pass']) != $row['password']){
            return RequestResponse::getResponse('原密码不正确！','error',0);
        }
        model('Admin')->where('id',$id)->update(['password'=>md5($post['password'])]);
        session(null);
        return RequestResponse::getResponse();
    }
    /**
     * 删除管理员
     * @return array
     */
    public function delete(){
        $id = input('post.id');
        $row = model('Admin')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误id','error',0);
        }
        model('Admin')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
}