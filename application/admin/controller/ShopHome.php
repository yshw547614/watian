<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/11/9 0009
 * Time: 上午 10:37
 */

namespace app\admin\controller;


use think\Controller;

class ShopHome extends Controller
{
    public function index(){
        return $this->fetch('shop_set/home');
    }
    public function catProduct(){
        $datas = [];
        $catProducts = model('HomeProduct')->order('rank asc')->select();
        $categoryField = 'id,name,en_name';
        $productField = 'id,name,short_name,thumb_img,big_thumb_img,category_id';
        foreach ($catProducts as &$catProduct){
            $data['id'] = $catProduct['id'];
            $data['category'] = model('Category')->field($categoryField)->where('id',$catProduct['category_id'])->find()->toArray();
            $data['top_product'] = model('Product')->field($productField)->where('id',$catProduct['top_product_id'])->find()->toArray();
            $data['list_products'] = model('Product')->field($productField)->where('id','in',$catProduct['list_product_ids'])->select()->toArray();
            $rankArr = explode(',',$catProduct['list_product_ids']);
            array_multisort($rankArr,SORT_ASC,$data['list_products']);
            array_push($datas,$data);
        }
        return json($datas);

    }

    public function recommend(){
        $recommend = model('ProductRecommend')->where('group_num',1)->find();
        if($recommend){
            $products = model('Product')->where('id','in',$recommend['product_ids'])->select()->toArray();
            $rankArr = explode(',',$recommend['product_ids']);
            array_multisort($rankArr,SORT_ASC,$products);
            $recommend['products'] = $products;
        }
        return json($recommend);
    }
    public function handle(){
        $data = input('post.');
        $this->updateBanner($data['banner']);
        $this->updateSlogan($data['slogan']);
        $this->updateNavCat($data['cat_nav']);
        $this->updateHomeProduct($data['cat_product']);
        $this->updateProductRecommend($data['recommend']);
    }
    public function updateProductRecommend($data){
        model('ProductRecommend')->isUpdate(true)->save($data);
    }
    public function updateHomeProduct($datas){
        $datas = array_values($datas);
        $homeProducts = $categories = $products = [];
        foreach ($datas as $key => $data){
            $listProductIds = implode(',',array_column($data['list_product'],'id'));
            isset($data['id']) && $homeProduct['id'] = $data['id'];
            $homeProduct['category_id'] = $data['cat']['id'];
            $homeProduct['top_product_id'] = $data['top_product']['id'];
            $homeProduct['list_product_ids'] = $listProductIds;
            $homeProduct['rank'] = $key;
            array_push($homeProducts,$homeProduct);
            array_push($categories,$data['cat']);
            array_push($products,$data['top_product']);
            foreach ($data['list_product'] as $product){
                array_push($products,$product);
            }

        }
        $homeProductIds = array_column($homeProducts,'id');
        $total = model('HomeProduct')->count();
        $count = count($homeProductIds);
        if($count<$total){
            model('HomeProduct')->where('id','not in',$homeProductIds)->delete();
        }
        model('HomeProduct')->saveAll($homeProducts);
        model('Category')->saveAll($categories);
        model('Product')->saveAll($products);
    }
    public function updateBanner($datas){
        $datas = array_values($datas);
        foreach ($datas as $key => &$data){
            $data['rank'] = $key;
            $data['advert_id'] = 1;
            isset($data['id']) && $data['title'] = "首页banner";
            $data['img_url'] = $data['img'];
            unset($data['img']);
        }
        $ids = array_column($datas,'id');
        $count = count($ids);
        $total = model('AdvertItem')->where('advert_id',1)->count();
        if($count < $total){
            model('AdvertItem')->where('id','not in',$ids)->where('advert_id',1)->delete();
        }
        model('AdvertItem')->saveAll($datas);
    }
    public function updateSlogan($datas){
        $datas = array_values($datas);
        foreach ($datas as $key =>&$data){
            $data['rank'] = $key;
        }
        model('Slogan')->saveAll($datas);
    }
    public function updateNavCat($datas){
        $datas = array_values($datas);
        foreach ($datas as $key =>&$data){
            $data['rank'] = $key;
            $data['icon'] = $data['img'];
            unset($data['img']);
        }
        model('Navigation')->saveAll($datas);
    }
}