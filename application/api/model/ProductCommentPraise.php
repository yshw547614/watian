<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/10 0010
 * Time: 上午 9:38
 */

namespace app\api\model;


use app\api\service\Token;
use app\api\validate\IDMustBePositiveInt;
use app\common\response\RequestResponse;

class ProductCommentPraise extends BaseModel
{
    public static function updatePraise($id){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $comment = ProductComment::get($id);
        if(!$comment) return RequestResponse::getResponse('错误id号','error',400);
        $uid = Token::getCurrentTokenVar('uid');
        $praise = self::where(['user_id'=>$uid,'product_comment_id'=>$id])->find();
        if($praise){
            if($praise['status']==1){
                $praise->status = 2;
                $praise->save();
                $comment->praise -=1;
                $comment->save();
            }else{
                $praise->status = 1;
                $praise->save();
                $comment->praise +=1;
                $comment->save();
            }
        }else{
            $data = ['user_id'=>$uid,'product_comment_id'=>$id,'status'=>1];
            self::create($data);
            $comment->praise +=1;
            $comment->save();
        }
        return RequestResponse::getResponse('','','',['praise'=>$comment->praise]);
    }
}