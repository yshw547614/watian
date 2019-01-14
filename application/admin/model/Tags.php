<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/30 0030
 * Time: 下午 3:01
 */

namespace app\admin\model;


use app\common\response\RequestResponse;

class Tags extends BaseModel
{
    public function category(){
        return $this->belongsTo('TagsType','type_id','id');
    }
    public function dataFilter($data){
        $list = [];
        if(isset($data['title']) && is_array($data['title']))
        {
            foreach($data['title'] as $value){
                (!empty($value)) && $list[] = [
                    'type_id'=>$data['type_id'],
                    'title'=>$value,
                    'language'=>$data['language']
                ];
            }
        }
        return $list;
    }
    public function addTags($data){
        $list = $this->dataFilter($data);
        if(!empty($list)){
            $this->saveAdd($list,$data['type_id']);
        }else{
            $this->error('数据不能为空');
        }
    }
    public function saveAdd($list,$typeid){
        if($this->saveAll($list)){
            $this->success('添加标签成功',url('index',['typeid'=>$typeid]));
        }else{
            $this->error('添加标签失败');
        }
    }
    public function del($id){
        $flag = false;
        $userTags = new UserTags();
        $this::destroy($id) && $flag = true;
        $flag && $userTags->where('tags_id','=',$id)->delete();
        if($flag){
            $this->success('标签删除成功');
        }else{
            $this->error('标签删除失败');
        }
    }
    public function edit($data){
        $isUnique = $this->isUnique(['title'=>$data['title'],'id'=>['neq',$data['id']]],'',true);
        if(!$isUnique){
            return RequestResponse::getResponse('标签名称已存在','error');
        }
        $validate = $this->validate(true)->isUpdate(true)->save($data);
        if(false === $validate){
            return RequestResponse::getResponse($this->getError(),'error');
        }else{
            return RequestResponse::getResponse('标签更新成功');
        }
    }
}