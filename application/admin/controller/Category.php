<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/2 0002
 * Time: 上午 11:11
 */

namespace app\admin\controller;

use app\admin\model\Category as CategoryModel;
use app\common\response\RequestResponse;

class Category extends BaseController
{
    public function index(){
        return $this->fetch();
    }

    public function topCategory(){
        return $this->fetch('top_category');
    }
    public function childCategory(){
        return $this->fetch('child_category');
    }
    public function treeCategory(){
        $categoryModel = new CategoryModel();
        $categoryArr = $categoryModel->getTreeResult('id','pid');
        return json($categoryArr);
    }
    public function getList(){
        $categoryModel = new CategoryModel();
        $categoryArr = $categoryModel->getTreeResult('id','pid');
        return json($categoryArr);
    }

    public function getTopCategory(){
        $list = model('Category')->where('pid',0)->select();
        return $list;
    }
    public function getOneCategory(){
        $param = request()->param();
        $row = model('Category')->where('id',$param['id'])->find();
        return $row;
    }
    public function updateRank(){
        $post = input('post.');
        $data = [
            'id' => $post['category_id'],
            'rank' => $post['rank']
        ];
        model('Category')->isUpdate(true)->save($data);
        $result = RequestResponse::getResponse();
        return json($result);
    }
    public function saveTopCategory(){

    }
    public function saveData(){
        $post = input('post.');
        $isUpdate = isset($post['id'])?true:false;
        model('Category')->isUpdate($isUpdate)->save($post);
        return RequestResponse::getResponse();
    }
    public function delete(){
        $id = request()->param('id');
        $row = model('Category')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数id','error');
        }
        if($row['pid']==0){
            $childNums = model('Category')->where('pid',$row['id'])->count();
            if($childNums>0){
                return RequestResponse::getResponse('请先删除该分类的子分类','error');
            }
        }
        $productNums = model('Product')->where('category_id',$row['id'])->count();
        if($productNums>0){
            return RequestResponse::getResponse('请先删除该分类下的商品','error');
        }
        model('Category')->where('id',$id)->delete();
        return RequestResponse::getResponse('删除成功');

    }
}