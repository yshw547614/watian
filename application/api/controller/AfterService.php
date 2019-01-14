<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/4 0004
 * Time: 下午 2:39
 */

namespace app\api\controller;

use app\api\service\Token;
use app\api\validate\AfterService as AfterServiceValidate;
use app\api\model\AfterService as AfterServiceModel;
use app\api\validate\Delivery;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use app\common\enum\ReturnStatusEnum;
use app\common\response\RequestResponse;
use app\common\service\JsonConfig;
use think\Exception;

class AfterService extends BaseController
{
    public function apply(){
        $validate = new AfterServiceValidate();
        $validate->checkUp();
        $postOrderProducts = input('post.order_products/a');
        $orderProductIds = array_column($postOrderProducts,'order_product_id');
        $noApplyCount = model('OrderProduct')->where(['id'=>['in',$orderProductIds],'is_return'=>1])->count();
        if($noApplyCount>0){
            return RequestResponse::getResponse('申请商品中包含已经申请售后的商品','error',406);
        }
        $orderProducts = model('OrderProduct')->all($orderProductIds);
        $orderProducts && $orderProducts = $orderProducts->toArray();
        $orderIds = array_unique(array_column($orderProducts,'order_id'));
        if(count($orderIds)>1){
            throw new Exception('错误参数',408);
        }
        $orderId = $orderIds[0];
        $totalPrice = array_sum(array_column($orderProducts,'total_price'));
        $model = new AfterServiceModel();
        $status_remark = $model->checkPostOrderProduct($postOrderProducts);
        $afterService = $model->createAfterService($orderId,$totalPrice,$status_remark);
        $model->createAfterServiceProduct($postOrderProducts,$orderProducts,$afterService->id);
        model('OrderProduct')->where('id','in',$orderProductIds)->update(['is_return'=>1]);
        return RequestResponse::getResponse();
    }
    public function getUserAfterService($page=1,$size=20){
        $validate = new PagingParameter();
        $validate->checkUp();
        $model = new AfterServiceModel();
        $uid = Token::getCurrentTokenVar('uid');
        $query = $model->getAfterService();
        $list = $query->order('create_time desc')->where('user_id',$uid)->paginate($size,true,['page'=>$page]);
        $list->visible(['id','order_no','status','create_time','after_service_product.order_product']);
        $dataArr = $list->toArray();
        $afterServices = $dataArr['data'];
        foreach ($afterServices as &$afterService){
            $afterService['refund_fee'] = 0;
            $afterService['refund_count'] = 0;
            foreach ($afterService['after_service_product'] as &$after_service_product){
                $after_service_product = $after_service_product['order_product'];
                unset($after_service_product['id']);
                $afterService['refund_fee'] += $after_service_product['total_price'];
                $afterService['refund_count'] += $after_service_product['count'];
            }
        }
        $data = [
            'list' => $afterServices,
            'page' => $dataArr['current_page'],
            'has_more' => $dataArr['has_more']
        ];
        return RequestResponse::getResponse('','','',$data);
    }
    public function getOneAfterService($id){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $model = new AfterServiceModel();
        $query = $model->getAfterService();
        $data = $query->where('id',$id)->find();
        if(!$data){
            return RequestResponse::getResponse('错误参数id','error',404);
        }
        $visibleField = [
            'order_id',
            'status',
            'create_time',
            'remark',
            'refund_money',
            'refund_type',
            'refund_mark',
            'delivery',
            'after_service_product.reason',
            'after_service_product.describe',
            'after_service_product.images',
            'after_service_product.order_product',
        ];
        $data->visible($visibleField);
        if($data){
            $data->hidden(['product.id']);
            return RequestResponse::getResponse('','','',$data);
        }else{
            return RequestResponse::getResponse('错误id号','error',400);
        }
    }
    public function getCanApplyList($id=0){
        $uid = Token::getCurrentUid();
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $list = model('OrderProduct')->field('id order_product_id,name,thumb_img,original_price,price,count,total_price,nation')
            ->where(['order_id'=>['in',$id],'user_id'=>$uid,'is_return'=>0])->select();
        if(!$list){
            return RequestResponse::getResponse('该订单不能申请售后','error',407);
        }
        return RequestResponse::getResponse('','','',$list);
    }
    public function cancelAplly($id){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $afterService = AfterServiceModel::get($id);
        if(!$afterService) return RequestResponse::getResponse('错误id参数','error',400);
        $afterService->status = ReturnStatusEnum::CANCEL;
        $afterService->canceltime = time();
        $afterService->remark = "如有疑问请您在线联系客服";
        $afterService->save();
        $orderProductIds = model('AfterServiceProduct')->where('after_service_id','in',$id)
            ->column('order_product_id');
        model('OrderProduct')->where('id','in',$orderProductIds)->update(['is_return'=>0]);
        return RequestResponse::getResponse();
    }
    public function delivery(){
        $validate = new Delivery();
        $validate->checkUp();
        $data = input('post.');
        $uid = Token::getCurrentUid();
        $afterService = model('AfterService')->where(['id'=>$data['service_id'],'user_id'=>$uid])->find();
        if(!$afterService){
            throw new Exception('错误参数',403);
        }
        unset($data['service_id']);
        $afterService->delivery = serialize($data);
        $afterService->status = ReturnStatusEnum::DELIVERY;
        $afterService->remark = "待商家收货验证入库，即可进入下一环节";
        $afterService->save();
        return RequestResponse::getResponse();
    }

    public function getReturnReason(){
        $reason = config('return.reason');
        return RequestResponse::getResponse('','','',$reason);
    }

    public function getStoreAddress(){
        $data = JsonConfig::get('store.receive');
        return RequestResponse::getResponse('','','',$data);
    }
}