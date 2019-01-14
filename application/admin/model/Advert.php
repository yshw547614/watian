<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/5 0005
 * Time: 下午 3:26
 */

namespace app\admin\model;

use app\common\model\Advert as CommenAdvert;

class Advert extends BaseModel
{
    use CommenAdvert;

    public function del($id){
        $flag = false;
        $advertItem = new AdvertItem();
        $itemIds = $advertItem->where('advert_id',$id)->column('id');
        AdvertItem::destroy($itemIds) && $flag = true;
        $this::destroy($id) && $flag = true;
        if($flag){
            $this->success('广告位删除成功',url('index'));
        }else{
            $this->error('广告位删除失败');
        }
    }
}