<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/30 0030
 * Time: 上午 11:36
 */

namespace app\admin\model;

use app\admin\model\Tags;
use think\Db;
use think\Exception;

class TagsType extends Type
{
    public function del($id){
        $tagsModel = new Tags();
        $userTagsModel = new UserTags();
        $tagsId = $tagsModel->where(['type_id'=>$id])->column('id');
        $userTagsId = $userTagsModel->where('tags_id','in',$tagsId)->column('id');
        Db::startTrans();
        try{
            $tagsModel->where(['type_id'=>$id])->delete();
            $userTagsModel->where('id','in',$userTagsId)->delete();
            $this::destroy($id);
            Db::commit();
            $this->success('标签分类删除成功');
        }catch ( Exception $e){
            Db::rollback();
            $this->error($e->getMessage());
        }
    }
}