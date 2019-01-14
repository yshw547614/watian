<?php

namespace app\api\model;

use app\common\model\Category as CommonCategory;

class Category extends BaseModel
{
    protected $hidden = ['description','create_time','update_time'];
    use CommonCategory;
    public function products()
    {
        return $this->hasMany('Product', 'category_id', 'id');
    }

    public  function getHomeCategorys($size){
        $list = [];
        $categoryProducts = model('HomeProduct')->order('rank asc')->select();
        foreach ($categoryProducts as $categoryProduct){
            $data = $this->getCategory($categoryProduct['category_id']);
            $data['product_top'] = $this->getTopProduct($categoryProduct['top_product_id']);
            $data['product_list'] = $this->getListProducts($categoryProduct['list_product_ids'],$size);
            array_push($list,$data);
        }
        return $list;
    }

    protected function getCategory($id){
        $row = model('Category')->field('id,name,en_name')->where('id',$id)->find();
        return $row;
    }

    protected function getTopProduct($id){
        $row = model('Product')->field('id,big_thumb_img as thumb_img')->where('id',$id)->find();
        return $row;
    }

    protected function getListProducts($ids,$size){
        $rows = model('Product')->field('id,short_name as name,thumb_img')
            ->where('id','in',$ids)->limit($size)->select()->toArray();
        $rankArr = explode(',',$ids);
        array_multisort($rankArr,SORT_ASC,$rows);
        return $rows;
    }

}
