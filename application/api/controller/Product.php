<?php
/**
.
 * Date: 2017/2/15
 * Time: 1:00
 */

namespace app\api\controller;

use app\api\model\Product as ProductModel;
use app\api\model\ProductComment;
use app\api\model\ProductStore;
use app\api\model\UserKeyword;
use app\api\service\Token;
use app\api\validate\BaseValidate;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use app\api\validate\ProductCategory;
use app\common\enum\OrderStatusEnum;
use app\common\response\RequestResponse;
use app\common\service\JsonConfig;
use think\Controller;

class Product extends Controller
{
    
    /**
     * 根据类目ID获取该类目下所有商品(分页）
     * @url /product?id=:category_id&page=:page&size=:page_size
     * @param int $id 商品id
     * @param int $page 分页页数（可选)
     * @param int $size 每页数目(可选)
     * @return array of Product
     */
    public function getByCategory($id = -1, $page = 1, $size = 30,$rank=1)
    {
        $validate = new ProductCategory();
        $validate->checkUp();
        $categoryName = model('Category')->where('id',$id)->value('name');
        $list = ProductModel::getProductsByCategoryId($id, true, $page, $size,$rank);
        $dataArr = $list->toArray();
        $data = [
            'current_page' => $dataArr['current_page'],
            'has_more' => $dataArr['has_more'],
            'list' => $dataArr['data'],
            'category_name' => $categoryName,
        ];

        return RequestResponse::getResponse('','','',$data);
    }

    /**
     * 获取某分类下全部商品(不分页）
     * @url /product/all?id=:category_id
     * @param int $id 分类id号
     */
    public function getAllInCategory($id = -1,$rank=1)
    {
        $validate = new ProductCategory();
        $validate->checkUp();
        $products = ProductModel::getProductsByCategoryId($id, false,'','',$rank);
        $categoryName = model('Category')->where('id',$id)->value('name');
        $data = [
            'category_name' => $categoryName,
            'list' => $products,
        ];
        return RequestResponse::getResponse('','','',$data);

    }

    /**
     * 获取指定数量的最近商品
     * @param int $count
     * @return mixed
     */
    public function getRecent($count = 15)
    {
        $validate = new Count();
        $validate->checkUp();
        $products = ProductModel::getMostRecent($count);
        $products = $products->toArray();
        return $products;
    }


    public function getOne($id){
        $uid = Token::getCurrentTokenVar('uid');
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $productField = 'id,name,thumb_img,original_price,price,stock,clicks,sales_volume,nation,is_free_shipping,is_on_sale,service_template_id';
        $product = model('Product')->field($productField)->where('id',$id)->find()->toArray();
        if(!$product){
            return RequestResponse::getResponse('商品Id错误','error',404);
        }
        model('Product')->where('id',$id)->setInc('clicks');
        $addonsFeild = 'topic_img,main_img,property';
        $addons = model('ProductAddons')->field($addonsFeild)->where('product_id',$id)->find()->toArray();
        $product = array_merge($product,$addons);
        $store = ProductStore::get(['user_id'=>$uid,'product_id'=>$id,'is_store'=>1]);
        $is_store = $store?true:false;
        $product['is_store'] = $is_store;
        $productService = model('ProductService')->field('name,link')
            ->where('template_id',$product['service_template_id'])->select()->toArray();
        $freeLowerLimt = JsonConfig::get('store.freight_free');
        $product['promote'] = ['全场满'.$freeLowerLimt.'包邮'];
        $product['service_explain'] = $productService;
        $comments = ProductComment::getProductComment($id);
        $product['comment'] = $comments;
        unset($product['service_template_id']);
        return RequestResponse::getResponse('','','',$product);
    }

    public function recommend($id=-1,$size=6,$type=''){
        $validate = new PagingParameter();
        $validate->checkUp();
        switch($type){
            case 'detail':
                $recommend = $this->detailRcommend($id,$size);
                break;
            default:
                $recommend = model('Product')->where('is_vouch',1)->limit($size)->select();
        }
        return RequestResponse::getResponse('','','',$recommend);
    }
    public function detailRcommend($id,$size){
        $rule = [
            'id' => 'require|isPositiveInteger',
            'size' => 'isPositiveInteger'
        ];
        $data = [
            'id' => $id,
            'size' =>$size,
        ];
        $map = [
            'is_on_sale' => 1,
            'stock' => ['>',0]
        ];
        $validate = new BaseValidate($rule);
        if(!$validate->check($data)){
            return RequestResponse::getResponse($validate->getError(),'error',403);
        }
        $categoryId = model('Product')->where('id',$id)->value('category_id');
        if(!$categoryId){
            return RequestResponse::getResponse('商品Id错误','error',404);
        }
        $productField = [
            'id',
            'name',
            'thumb_img',
            'original_price',
            'price',
            'stock',
            'clicks',
            'sales_volume',
            'nation'
        ];
        $selfProducts = model('Product')->field($productField)->where('category_id',$categoryId)
            ->where('id','neq',$id)->where($map)->limit($size)->select();
        if($selfProducts){
            $selfProducts = $selfProducts->toArray();
        }
        $count = count($selfProducts);
        if($count==$size){
            $recommend = $selfProducts;
        }else{
            $pid = model('Category')->where('id',$categoryId)->value('pid');
            $categoryIds = model('Category')->where('id','neq',$categoryId)->where('pid',$pid)->column('id');
            $num = $size - $count;
            $parentProducts = model('Product')->where(['is_home'=>1,'category_id'=>['in',$categoryIds]])
                ->where($map)->field($productField)->limit($num)->select();
            if($parentProducts){
                $parentProducts = $parentProducts->toArray();
            }
            $selfProducts = is_array($selfProducts)?$selfProducts:[];
            $parentProducts = is_array($parentProducts)?$parentProducts:[];
            $recommend = array_merge($selfProducts,$parentProducts);
        }
        return $recommend;
    }
    public function store($id){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $product = ProductModel::get($id);
        if(!$product){
            return RequestResponse::getResponse('错误参数Id','error',400);
        }
		$uid = Token::getCurrentTokenVar('uid');
        $productStore = model('ProductStore')->where('user_id',$uid)->where('product_id',$id)->find();
        if($productStore){
            if($productStore->is_store == 1){
                $productStore->is_store = 2;
                $productStore->save();
                return RequestResponse::getResponse('已取消收藏');
            }else{
                $productStore->is_store = 1;
                $productStore->save();
                return RequestResponse::getResponse('收藏成功');
            }

        }else{
            $data['product_id'] = $id;
            $data['user_id'] = $uid;
            $result = ProductStore::create($data);
            if($result){
                return RequestResponse::getResponse('收藏成功');
            }else{
                return RequestResponse::getResponse("收藏商品失败",'error',502);
            }
        }
    }
    public function userProductStore($page=1,$size=20){
        $uid = Token::getCurrentTokenVar('uid');
        $list = model('ProductStore')->where(['user_id'=>$uid,'is_store'=>1])->with(
                [
                    'product' => function($query){
                        $query->field('id,name,thumb_img,original_price,price,stock');
                    }
                ]
            )->paginate($size,true,['page'=>$page]);
        $list->hidden(['user_id','product_id','is_store']);
        $dataArr = $list->toArray();
        $data = [
            'list' => $dataArr['data'],
            'page' => $dataArr['current_page'],
            'has_more' => $dataArr['has_more']
        ];
        return RequestResponse::getResponse('','','',$data);
    }

    public function receive($id){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $order = model('Order')->where('id',$id)->where('status',OrderStatusEnum::DELIVERED)->find();
        if(!$order){
            return RequestResponse::getResponse('无效的id参数','error',400);
        }
        $order->status = OrderStatusEnum::RECEIVE;
        $order->confirm_time = time();
        $order->save();
        model('OrderProduct')->where('order_id','in',$id)->update(['evaluate'=>1]);
        return RequestResponse::getResponse();
    }

    public function search(){
        $data = input('post.');
        $rule = [
            'keyword' => 'require|isNotEmpty',
            'rank' => 'in:1,2,3,4,5'
        ];
        $baseValidate = new BaseValidate($rule);
        $baseValidate->checkUp();
        $uid = Token::getCurrentUid();
        $keyword = $data['keyword'];
        $rank = isset($data['rank'])?$data['rank']:1;
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
        $products = model('Product')->field('id,name,thumb_img,original_price,price,stock,nation')
            ->where('name','like','%'.$keyword.'%')
            ->where(['is_on_sale'=>1,'stock'=>['>',0]])->order($order)->select();
        $insertData = [
            'keyword' => $keyword,
            'user_id' => $uid
        ];
        $userKeywordModel = new UserKeyword();
        $userKeyword = $userKeywordModel->where($insertData)->find();
        if($userKeyword){
            $userKeyword->update_time = time();
            $userKeyword->save();
        }else{
            $userKeywordModel->isUpdate(false)->save($insertData);
        }
        return RequestResponse::getResponse('','','',$products);
    }

    public function getSimilarity($id=-1,$size = 10){
        $list = $this->detailRcommend($id,$size);
        return RequestResponse::getResponse('','','',$list);
    }

    public function homeRecommend($page=1,$size=20){
        $validate = new PagingParameter();
        $validate->checkUp();
        $field = 'id,name,thumb_img,nation,original_price,price';

        $recommedProductIds = model('ProductRecommend')->where('group_num',1)
            ->order('id desc')->value('product_ids');

        $condition = [
            'id'=>['in',$recommedProductIds],
            'is_on_sale'=>1,
            'stock'=>['>',0]
        ];
        $recommedProducts = model('Product')->field($field)->where($condition)->select()->toArray();
        $rankArr = explode(',',$recommedProductIds);
        array_multisort($rankArr,SORT_ASC,$recommedProducts);

        $otherCondition = [
            'id'=>['not in',$recommedProductIds],
            'is_on_sale'=>1,
            'stock'=>['>',0]
        ];
        $otherProducts = model('Product')->field($field)->where($otherCondition)
            ->order('clicks desc')->select()->toArray();

        $products = array_merge($recommedProducts,$otherProducts);
        $total = count($products);//总条数
        $count = ceil($total/$size);//总页数
        $hasMore = $page<$count?true:false;
        $start=($page-1)*$size;
        $rows = array_slice($products,$start,$size);

        $data = [
            'has_more' => $hasMore,
            'page' => $page,
            'list' => $rows
        ];
        return RequestResponse::getResponse('','','',$data);
    }

    public function checkInvalidProduct(){
        $rule = [
            'product_ids' => 'require|array'
        ];
        $validate = new BaseValidate($rule);
        $validate->checkUp();
        $productIds = input('post.product_ids/a');
        $map['id'] = ['in',$productIds];
        $map['is_on_sale'] = 0;
        $map2['id'] = $map['id'];
        $map2['stock'] = ['<=',0];
        $list = model('Product')->where(
            function ($query) use ($map){
                $query->where($map);
            }
         )->whereOr(
             function ($query) use ($map2){
                $query->where($map2);
             }
        )->column('id');
        return RequestResponse::getResponse('','','',['invalid_product_ids'=>$list]);
    }

}