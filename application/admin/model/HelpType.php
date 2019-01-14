<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/11 0011
 * Time: 下午 8:04
 */

namespace app\admin\model;
use think\Db;
use think\Exception;

class HelpType extends Type
{
    public function del($id){
        $help = new Help();
        Db::startTrans();
        try{
            $help->where('type_id','=',$id)->delete();
            $this::destroy($id);
            Db::commit();
            $this->success('帮助分类删除成功');
        }catch ( Exception $e){
            Db::rollback();
            $this->error($e->getMessage());
        }
    }

}