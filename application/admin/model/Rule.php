<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/27 0027
 * Time: 上午 10:51
 */

namespace app\admin\model;

class Rule extends BaseModel
{
    public function handle(){
        $data = input('post.');
        $isUpdate = isset($data['id'])?true:false;
        $msgPrefix = $isUpdate?"更新数据":"新增数据";
        $this->checkData($data);
        $result = $this->isUpdate($isUpdate)->save($data);
        if($result){
            $this->success($msgPrefix.'成功',url('index'));
        }else{
            $this->error($msgPrefix.'失败');
        }
    }
}