<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/16 0016
 * Time: 下午 2:46
 */

namespace app\admin\model;
use app\common\model\ProductComment as ProductCommentCommon;

class ProductComment extends BaseModel
{
    protected $hidden = ['user_id','order_id','update_time'];
    public function product(){
        return $this->belongsTo('Product','product_id','id');
    }
    public function reply(){
        return $this->hasOne('ProductCommentReply','product_comment_id','id');
    }
    public function user(){
        return $this->belongsTo('User','user_id','id');
    }
    use ProductCommentCommon;

    public function getEvaluateAttr($value){
        $arr = [
            '1' => '好评',
            '2' => '中评',
            '3' => '差评'
        ];
        if(isset($arr[$value])){
            return $arr[$value];
        }else{
            return $arr[1];
        }
    }
    public function getStarAttr($value){
        $arr = [
            '1' => '一星',
            '2' => '二星',
            '3' => '三星',
            '4' => '四星',
            '5' => '五星'
        ];
        return $arr[$value];
    }
    public function getShowAttr($value,$data){
        $arr = [
            '否',
            '是'
        ];
        return $arr[$data['is_pass']];
    }
}