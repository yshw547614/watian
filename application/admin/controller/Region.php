<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/1
 * Time: 14:12
 */

namespace app\admin\controller;

use app\admin\model\Region as RegionModel;
use app\admin\validate\IdMustBePositiveInt;
use app\common\response\RequestResponse;

class Region extends BaseController
{
    public function index(){
        return $this->fetch();
    }
    public function getRegion(){
        $param = request()->param();
        $list = model('Region')->where('parent_id',$param['id'])->select()->toArray();
        if($param['level']=='city'){
            $last = [
                'name' =>'添加城市',
                'parent_id' =>$param['id'],
                'level' => 2
            ];
            array_push($list,$last);
        }
        if($param['level']=='country'){
            $last = [
                'name' =>'添加地区',
                'parent_id' =>$param['id'],
                'level' =>3
            ];
            array_push($list,$last);
        }
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'data' => $list
        ];
        return $data;
    }
    public function saveData(){
        $post = input('post.');
        $isUpdate = isset($post['id'])?true:false;
        model('Region')->isUpdate($isUpdate)->save($post);
        return RequestResponse::getResponse();
    }
    public function delete(){
        $id = input('post.id');
        $row = model('Region')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数id','error');
        }
        $childNums = model('Region')->where('parent_id',$id)->count();
        if($childNums>0){
            return RequestResponse::getResponse('请先删除下级地区');
        }
        model('Region')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }




}