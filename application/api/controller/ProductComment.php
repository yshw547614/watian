<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/25 0025
 * Time: 下午 3:12
 */

namespace app\api\controller;

use app\api\model\Product;
use app\api\model\ProductComment as Comment;
use app\api\validate\GetComments;
use app\api\validate\ProductComment as ProductCommentValidate;
use app\api\model\ProductCommentPraise;
use app\api\service\Token;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use app\common\response\RequestResponse;

class ProductComment
{
    public function getEvaluatedProduct($page=1,$size=10){
        $uid = Token::getCurrentUid();
        $visibleField = [
            'product.name',
            'product.thumb_img',
            'images',
            'content',
            'evaluate',
            'star',
            'create_time',
            'is_pass'
        ];
        $list = model('ProductComment')->with(
            [
                'product' => function($query){
                    $query->field('id,name,thumb_img');
                }
            ]
        )->where(['user_id'=>$uid])->order('create_time desc')->paginate($size,true,['page'=>$page]);
        $list->visible($visibleField);
        $list = $list->toArray();
        $data = [
            'list' => $this->getFormatData($list['data']),
            'page' => $list['current_page'],
            'has_more' => $list['has_more']
        ];
        return RequestResponse::getResponse('','','',$data);
    }
    public function getFormatData($list){
        $result = [];
        foreach ($list as $item){
            $data = [];
            $data['name'] = $item['product']['name'];
            $data['thumb_img'] = $item['product']['thumb_img'];
            $data['product_comment']['images'] = $item['images'];
            $data['product_comment']['content'] = $item['content'];
            $data['product_comment']['evaluate'] = $item['evaluate'];
            $data['product_comment']['star'] = $item['star'];
            $data['product_comment']['create_time'] = $item['create_time'];
            $data['product_comment']['is_pass'] = $item['is_pass'];
            array_push($result,$data);
        }
        return $result;
    }

    public function getWillEvaluateProduct($page=1,$size=10){
        $validate = new PagingParameter();
        $validate->checkUp();
        $uid = Token::getCurrentUid();
        $list = model('OrderProduct')->field('id as order_product_id,name,thumb_img')
            ->where(['user_id'=>$uid,'evaluate'=>1])->order('id desc')
            ->paginate($size,true,['page'=>$page]);
        $list = $list->toArray();
        $data = [
            'list' => $list['data'],
            'page' => $list['current_page'],
            'has_more' => $list['has_more']
        ];
        return RequestResponse::getResponse('','','',$data);
    }
    public function addComment(){
        $data = input('post.');
        $validate = new ProductCommentValidate();
        $validate->checkUp();
        $uid = Token::getCurrentUid();
        $orderProductId = $data['order_product_id'];
        $orderProduct = model('OrderProduct')->get($orderProductId);
        if(!$orderProduct){
            return RequestResponse::getResponse('order_product_id错误','error',406);
        }
        $data['user_id'] = $uid;
        $data['product_id'] = $orderProduct['product_id'];
        model('ProductComment')->allowField(true)->save($data);
        $orderProduct->evaluate = 2;
        $orderProduct->save();
        return RequestResponse::getResponse();
    }

    public function getCommentCount($id=0){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        return Comment::commentCount($id);
    }

    public function getComments($id=0,$type=0,$page=1,$size=20){
        $validate = new GetComments();
        $validate->checkUp();
        $product = Product::get($id);
        if(!$product){
            return RequestResponse::getResponse('错误id参数','error',400);
        }
        $data = Comment::getComments($id,$type,$page,$size);
        return RequestResponse::getResponse('','','',$data);
    }

    public function userCommentCount(){
        $uid = Token::getCurrentUid();
        $will_evaluate_num = model('OrderProduct')->where(['user_id'=>$uid,'evaluate'=>1])->count();
        $already_evaluate_num = model('OrderProduct')->where(['user_id'=>$uid,'evaluate'=>2])->count();
        $data = [
            'will_evaluate_num' => $will_evaluate_num,
            'already_evaluate_num' => $already_evaluate_num,
        ];
        return RequestResponse::getResponse('','','',$data);
    }
    public function updatePraise($id){
        return ProductCommentPraise::updatePraise($id);
    }

    public function getProductByOrderProductid($order_product_id){
        $orderProduct = model('OrderProduct')->field('id order_product_id,name,thumb_img')
            ->where('id',$order_product_id)->find();
        if(!$orderProduct){
            return RequestResponse::getResponse('错误参数order_product_id','error',408);
        }
        return RequestResponse::getResponse('','','',$orderProduct);
    }
}