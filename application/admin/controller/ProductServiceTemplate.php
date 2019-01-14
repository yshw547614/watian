<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/15 0015
 * Time: 下午 3:43
 */

namespace app\admin\controller;

use app\admin\model\ProductServiceTemplate as ProductServiceTemplateModel;
use app\common\response\RequestResponse;

class ProductServiceTemplate extends BaseController
{
    public function index(){
        return $this->fetch('after_service/template');
    }
    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];

        $rows = model('ProductServiceTemplate')->with(['items','products'=>function($query){
            $query->field('id,service_template_id');
        }])->paginate($limit)->toArray();

        $dataArrs = $rows['data'];

        foreach ($dataArrs as &$arr){
            $arr['item_str'] = $this->getRelationData($arr['items'],'name');
            unset($arr['items']);
            if($arr['is_all_product']){
                $arr['product_str'] = '全部商品';
            }else{
                $arr['product_str'] = $this->getRelationData($arr['products'],'id');
            }
            unset($arr['products']);
        }
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'count' => $rows['total'],
            'data' => $dataArrs
        ];
        return $data;
    }
    public function getRelationData($arr,$colunm){
        $itemArr = array_column($arr,$colunm);
        $str = implode(',',$itemArr);
        return $str;
    }

    public function template(){
        return $this->fetch('after_service/template_edit');
    }
    public function getTemplate(){
        $id = input('get.id');
        $row = model('ProductServiceTemplate')->where('id',$id)->find();
        $productIds = model('Product')->where('service_template_id',$id)->column('id');
        $row['product_ids'] = $productIds;
        return $row;
    }
    public function saveData(){
        $model = new ProductServiceTemplateModel();
        $post = input('post.');
        $isUpdate = isset($post['id'])?true:false;
        $productIds = $post['product_ids'];
        $items = $post['item'];
        $isAllProduct = $post['is_all_product'];
        unset($post['product_ids']);
        unset($post['item']);
        $model->isUpdate($isUpdate)->save($post);
        $this->updateItems($items,$model->id);
        $this->updateProducts($productIds,$model->id,$isAllProduct);
        return RequestResponse::getResponse();
    }
    public function updateItems($items,$templateId){
        foreach ($items as &$item){
            $item['template_id'] = $templateId;
        }
        model('ProductService')->saveAll($items);
    }
    public function updateProducts($productIds,$templateId,$isAllProduct){
        if($isAllProduct){
            model('Product')->where('id','>',0)->update(['service_template_id'=>$templateId]);
        }else{
            $products = explode(',',$productIds);
            model('Product')->where('id','in',$products)->update(['service_template_id'=>$templateId]);
        }

    }
    public function getItems(){
        $id = input('get.id');
        $rows = model('ProductService')->where('template_id',$id)->select();
        return $rows;
    }

    public function delete(){
        $id = input('post.id');
        $row = model('ProductServiceTemplate')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数Id');
        }
        $productNums = model('Product')->where('service_template_id',$id)->count();
        if($productNums>0){
            return RequestResponse::getResponse('已有商品使用该模板，不能删除','error');
        }
        model('ProductServiceTemplate')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
}