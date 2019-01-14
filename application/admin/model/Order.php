<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/29
 * Time: 22:13
 */

namespace app\admin\model;

use app\admin\service\DeliveryMessage;
use app\admin\validate\BaseValidate;
use app\admin\validate\IdMustBePositiveInt;
use app\common\enum\OrderStatusEnum;
use app\common\model\Order as OrderCommon;
use app\common\response\RequestResponse;
use think\Exception;
use think\Validate;

class Order extends BaseModel
{
    use OrderCommon;

    public function getSnapAddressAttr($value)
    {
        if (!empty($value)) {
            $arr = json_decode(($value));
            return $arr;
        }
    }

    public function user(){
        return $this->belongsTo('User','user_id','id');
    }
    public function getUserAddressAttr($value,$data){
        if(!empty($data['snap_address'])){
            $arr = json_decode(($data['snap_address']));
            return $arr->name.':'.$arr->mobile;
        }
    }
    public function getExpressTitleAttr($value,$data){
        if($data['status'] == OrderStatusEnum::RECEIVE){
            $express = model('Express')->get($data['express_id']);
            if($express){
                return $express['title'];
            }
        }
    }
    public function getStatusChinaAttr($value,$data){
        $status = [
            OrderStatusEnum::REFUND => '已退款',
            OrderStatusEnum::CANCEL => '已取消',
            OrderStatusEnum::UNPAID => '待支付',
            OrderStatusEnum::PAID => '待发货',
            OrderStatusEnum::DELIVERED => '待收货',
            OrderStatusEnum::RECEIVE => '交易完成'
        ];
        if(isset($status[$data['status']])){
            return $status[$data['status']];
        }
    }

    public function getIsPayAttr($value){
        $status = [
            '0' => '未支付',
            '1' => '已支付',
        ];
        return $status[$value];
    }
    public function getIsDeliveryAttr($value){
        $status = [
            '0' => '未发货',
            '1' => '已发货',
        ];
        return $status[$value];
    }

    public static function getDetail($id){
        $validate = new IdMustBePositiveInt();
        $validate->checkData(['id'=>$id]);
        $data = self::get($id,'snap_items');
        if(!$data){
            throw new Exception('错误id',403);
        }
        $logistics = [
            OrderStatusEnum::PAID,
            OrderStatusEnum::DELIVERED,
            OrderStatusEnum::RECEIVE
        ];
        if(in_array($data['status'],$logistics)){
            $express = Express::all();
            $data['express'] = $express;
        }
        $user = model('User')->where('id',$data['user_id'])->field('id,nickname,head_img')->find();
        $data['user'] = $user;
        return $data;
    }
    public function delivery(){
        $post = input('post.');
        $rule = [
            'company|快递公司' => 'require|isPositiveInteger',
            'odd_number|快递单号' =>'require|isNotEmpty',
        ];
        $validate = new BaseValidate($rule);
        $validate->checkData($post,true);

        $order = $this->where('id',$post['order_id'])->find();
        if(!$order){
            throw new Exception('错误id',403);
        }
        $data = [
            'id' => $post['order_id'],
            'express_id' => $post['company'],
            'odd_number' => $post['odd_number'],
            'status' => OrderStatusEnum::DELIVERED,
            'is_delivery' => 1,
            'shipping_time' => time(),
            'action_note' => '卖家已发货，请在收到货物后点确认签收吧！祝亲购物愉快',

        ];
        $this->isUpdate(true)->save($data);
        $deliveryMessage = new DeliveryMessage();
        $deliveryMessage->sendDeliveryMessage($order['id']);
        return RequestResponse::getResponse();
    }
}