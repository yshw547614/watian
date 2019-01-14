<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/2 0002
 * Time: 上午 11:10
 */

namespace app\admin\controller;

use app\common\response\RequestResponse;

class Product extends BaseController
{

    public function index(){
        return $this->fetch();
    }
    public function product(){
        return $this->fetch();
    }
    public function selectPage(){
        return $this->fetch('select_page');
    }
    public function comment(){
        return $this->fetch('product_comment/index');
    }
    public function getOneProduct($id){
        $data = model('Product')->with('addons')->where('id',$id)->find();
        return $data;
    }
    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $map = $this->getMap($param);
        if(!empty($map)){
            $products = model('Product')->where($map)->paginate($limit)->toArray();
        }else{
            $products = model('Product')->paginate($limit)->toArray();
        }
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'map' =>$map,
            'count' => $products['total'],
            'data' => $products['data'],
        ];
        return $data;
    }
    public function getMap($param){
        $map = [];
        if(isset($param['is_search'])) {
            if ($param['product_name']) {
                $map['name'] = ['like', '%' . $param['product_name'] . '%'];
            }
            if ($param['nation']) {
                $map['nation'] = $param['nation'];
            }
            if ($param['category']) {
                $map['category_id'] = $param['category'];
            }
            if ($param['is_free_shipping']) {
                $map['is_free_shipping'] = $param['is_free_shipping'];
            }
        }
        if(isset($param['is_on_sale'])){
            $map['is_on_sale'] = $param['is_on_sale'];
        }
        if(isset($param['stock'])){
            if($param['stock']=='yes'){
                $map['stock'] = ['>',0];
            }
            if($param['stock']=='no'){
                $map['stock'] = ['<=',0];
            }
        }

        return $map;
    }
    public function freightTempView(){
        return $this->fetch('freight_template');
    }
    public function afterServiceTempView(){
        return $this->fetch('after_service_template');
    }
    public function saveData(){
        $model = model('Product');
        $post = input('post.');
        $isUpdate = isset($post['id']) ? true : false;
        $is_free_shipping = (isset($post['is_free_shipping']) && $post['is_free_shipping'] === 'on')?1:0;
        $post['is_free_shipping'] = $is_free_shipping;
        if(isset($post['is_free_shipping'])){
            $post['upper_shelf_time'] = strtotime($post['upper_shelf_time']);
        }
        $addons = ['topic_img','main_img','property'];
        $addonsData = [];
        foreach ($addons as $addon){
            $addonsData[$addon] = $post[$addon];
            unset($post[$addon]);
        }
        $model->isUpdate($isUpdate)->save($post);
        $productId = $model->id;
        $this->updateProductSn($productId,$post['category_id']);
        $addonsData['product_id'] = $productId;
        if($isUpdate){
            model('ProductAddons')->where('product_id',$productId)->update($addonsData);
        }else{
            model('ProductAddons')->isUpdate(false)->save($addonsData);
        }

        $result = RequestResponse::getResponse();
        return $result;
    }
    public function updateProductSn($productId,$categoryId){
        $parentCategoryId = model('Category')->where('id',$categoryId)->value('pid');
        $data['id'] = $productId;
        $data['product_sn'] = 'WT'.$parentCategoryId.$categoryId.$productId;
        model('Product')->isUpdate(true)->save($data);
    }
    public function updateField(){
        $data = input('post.');
        model('Product')->isUpdate(true)->save($data);
        $result = RequestResponse::getResponse();
        return $result;
    }
    public function batchUpdate(){
        $data = input('post.');
        $ids = $data['productIds'];
        unset($data['productIds']);
        model('Product')->where('id','in',$ids)->update($data);
        return RequestResponse::getResponse();
    }
    public function getFreightTemplate(){
        $list = model('FreightTemplate')->select();
        return $list;
    }
    public function getAfterServiceTemplate(){
        $list = model('ProductServiceTemplate')->select();
        return $list;
    }
    public function getProductAddons(){
        $param = request()->param();
        $row = model('ProductAddons')->where('product_id',$param['id'])->find();
        return $row;
    }

    public function delete(){
        $id = input('post.id');
        $row = model('Product')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数id','error');
        }
        $orderNums = model('OrderProduct')->where('product_id',$row['id'])->count();
        if($orderNums>0){
            return RequestResponse::getResponse('该商品已有订单，不能删除','error');
        }
        model('Product')->where('id',$row['id'])->delete();
        return RequestResponse::getResponse();
    }
}