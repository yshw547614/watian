<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/12 0012
 * Time: 下午 2:02
 */

namespace app\admin\model;
use app\admin\validate\BaseValidate;
use app\common\response\RequestResponse;

class Type extends BaseModel
{
    public function add($data,$rule){
        $validate = new BaseValidate($rule);
        if(!$validate->checkData($data)){
            return RequestResponse::getResponse($validate->getError(),'error',400);
        }
        if(!$this->isUpdate(false)->save($data)){
            return RequestResponse::getResponse('添加失败','error',400);
        }else{
            return RequestResponse::getResponse('添加成功');
        }
    }
    public function edit($data,$rule){
        $validate = new BaseValidate($rule);
        if(!$validate->checkData($data)){
            return RequestResponse::getResponse($validate->getError(),'error',400);
        }
        $type = $this->get(['title'=>$data['title'],'id'=>['neq',$data['id']]]);
        if($type){
            return RequestResponse::getResponse('标题已存在','error',400);
        }
        if(!$this->isUpdate(true)->save($data)){
            return RequestResponse::getResponse('修改失败','error',502);
        }else{
            return RequestResponse::getResponse('修改成功');
        }
    }
}