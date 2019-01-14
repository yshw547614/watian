<?php

namespace app\api\model;

use app\common\model\Product as CommonProduct;

class Product extends BaseModel
{
    protected $hidden = [
        'is_home',
        'is_vouch',
        'category_id',
        'create_time',
        'update_time',
        'product_sn'
    ];

    use CommonProduct;

    public function getThumbImgAttr($value)
    {
        if($value){
            return $this->getImgUrl($value);
        }
    }

    public function getBigThumbImgAttr($value){
        if($value){
            return $this->getImgUrl($value);
        }
    }
    private function getImgUrl($imgName){
        $imgPath = config('domain');
        return $imgPath.$imgName;
    }

    public function comments(){
        return $this->hasMany('ProductComment','product_id','id');
    }
    public function getCategoryNameAttr($value,$data){
        $name = model('Category')->where('id',$data['category_id'])->value('name');
        return $name;
    }

    public static function getProductsByCategoryId($categoryId, $paginate = true, $page = 1, $size = 30,$rank=1)
    {
        switch ($rank){
            case 2:
                $order = ['create_time'=>'decs'];
                break;
            case 3:
                $order = ['clicks'=>'desc'];
                break;
            case 4:
                $order = ['price'=>'desc'];
                break;
            case 5:
                $order = ['price'=>'asc'];
                break;
            default:
                $order = ['sales_volume'=>'desc'];
        }
        $query = self::field('id,name,thumb_img,original_price,price,stock,clicks,sales_volume,nation')
            ->where('category_id',$categoryId)->where(['is_on_sale'=>1,'stock'=>['>',0]]);
        if (!$paginate)
        {
            $data = $query->order($order)->select();
        }else{
            $data =  $query->order($order)->paginate($size, true, ['page' => $page]);
        }
        return $data;
    }


    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

}
