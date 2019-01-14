<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/23 0023
 * Time: 下午 6:02
 */

namespace app\api\model;

use app\common\response\RequestResponse;
use app\common\model\ProductComment as ProductCommentCommon;
use think\Model;

class ProductComment extends Model
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['update_time'];
    public function user(){
        return $this->belongsTo('User','user_id','id');
    }

    use ProductCommentCommon;
    public function setImagesAttr($value){
        if($value){
            return serialize($value);
        }
    }

    public function product(){
        return $this->belongsTo('Product','product_id','id');
    }
    public static function getProductComment($productId,$size=2){
        $comments = [];
        $commentTotals = self::where(['product_id'=>$productId,'is_pass'=>1])->count();
        if($commentTotals){
            $evaluateCondition = ['product_id'=>$productId,'is_pass'=>1,'evaluate'=>1];
            $satisfiedTotals = self::where($evaluateCondition)->count();
            $satisfiedPercent = round(($satisfiedTotals/$commentTotals)*100).'%';
            $list = self::with(
                [
                    'user'=>function($query){
                        $query->field(['id','nickname','head_img']);
                    }
                ]
            )->where(['product_id'=>$productId,'is_pass'=>1])->order('create_time desc')->limit($size)->select();
            if($list){
                $comments['list'] = $list->hidden(['id','user_id','order_product_id','is_pass','product_id','update_time']);
                $comments['totals'] = $commentTotals;
                $comments['satisfiedPercent'] = $satisfiedPercent;
            }
        }
        return $comments;
    }

    /**
     * @param $productId 商品Id
     * @return array
     */
    public static function commentCount($productId){
        $product = Product::get($productId);
        if(!$product){
            return RequestResponse::getResponse('错误id参数','error',400);
        }
        $goodNum = $middleNum = $lowNum = $hasPicNum = 0;
        $comments = self::field('evaluate,images')->where(['product_id'=>$productId,'is_pass'=>1])->select();
        $totalNum = count($comments);
        if($totalNum>0){
            foreach ($comments as $comment){
                switch ($comment['evaluate']){
                    case 1:
                        $goodNum += 1;
                        break;
                    case 2:
                        $middleNum += 1;
                        break;
                    case 3:
                        $lowNum += 1;
                        break;
                }
                if(!empty($comment['images'])){
                    $hasPicNum += 1;
                }
            }
            $satisfiedPercent = round(($goodNum/$totalNum)*100).'%';
            $colligateScore = round(5*$goodNum/$totalNum,2);
            $commentCount = compact('totalNum','goodNum','middleNum','lowNum','hasPicNum','satisfiedPercent','colligateScore');
            return RequestResponse::getResponse('','','',$commentCount);
        }else{
            return RequestResponse::getResponse('该商品还没有评论','success',200);
        }
    }

    public static function getComments($productId,$type=0,$page=1,$size=20){
        $condition = [
            ['product_id'=>$productId,'is_pass'=>1],
            ['product_id'=>$productId,'is_pass'=>1,'evaluate'=>1],
            ['product_id'=>$productId,'is_pass'=>1,'evaluate'=>2],
            ['product_id'=>$productId,'is_pass'=>1,'evaluate'=>3],
            ['product_id'=>$productId,'is_pass'=>1,'images'=>['neq','']],
        ];
        $map = $condition[$type];
        $list = self::with(
            [
                'user'=>function($query){
                    $query->field('id,nickname,head_img');
                }
            ]
        )->where($map)->order('create_time desc')->paginate($size,true,['page'=>$page]);
        $list->hidden(['order_product_id','product_id','update_time','user_id','is_pass','user.id']);
        $dataArr = $list->toArray();
        $data = [
            'list' => $dataArr['data'],
            'page' => $dataArr['current_page'],
            'has_more' => $dataArr['has_more'],
        ];
        return $data;
    }
    public static function updateUserScore($uid,$evaluate){
        if($evaluate == 1){
            UserScore::createUserScore(2,$uid);
        }else{
            UserScore::createUserScore(1,$uid);
        }
    }

    public static function updateUserDistance($uid){
        UserDistance::createUserDistance($uid,1);
    }
}