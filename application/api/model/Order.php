<?php

namespace app\api\model;


use app\common\enum\OrderStatusEnum;
use app\common\response\RequestResponse;
use app\common\model\Order as OrderCommon;
use app\api\service\Order as OrderService;
use think\Db;
use think\Exception;

class Order extends BaseModel
{
    protected $hidden = ['user_id', 'is_pay','is_delivery','delete_time', 'update_time'];
    protected $autoWriteTimestamp = true;

    use OrderCommon;
    public function products()
    {
        return $this->belongsToMany('Product', 'order_product', 'product_id', 'order_id');
    }
    public function express(){
        return $this->belongsTo('Express','express_id','id');
    }
    public function setSnapImgAttr($value){
        $prefix = config('domain');
        return str_replace($prefix,'',$value);
    }
    public function getSnapImgAttr($value){
		$imgPath = config('domain');
        return $imgPath.$value;
    }
    public function getDeliveryTimeAttr($value){
        $type = [
            '1' => '送货时间不限',
            '2' => '仅周一至周五送货',
            '3' => '仅双休日/节假日送货'
        ];
        return $type[$value];
    }
    public function getSnapItemsAttr($value)
    {
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }
    
    public static function getSummaryByUser($uid, $page=1, $size=15,$type)
    {
        switch($type){
            case 'will_paid': //待支付
                $map['status'] = OrderStatusEnum::UNPAID;
                break;
            case 'will_delivery': //待发货
                $map['status'] = OrderStatusEnum::PAID;
                break;
            case 'will_receive': //待收货
                $map['status'] = OrderStatusEnum::DELIVERED;
                break;
        }
        $map['user_id'] = $uid;
        $visibleField = [
            'id',
            'order_no',
            'shipping_price',
            'order_price',
            'status',
            'total_count',
            'odd_number',
            'snap_items',
            'confirm_time',
            'express'
        ];

        $pagingData = self::with(
            [
                'snapItems'=>function($query){
                    $itemsField = [
                        'id' => 'order_product_id',
                        'order_id',
                        'product_id',
                        'name',
                        'thumb_img',
                        'original_price',
                        'price',
                        'total_price',
                        'count',
                        'nation'
                    ];
                    $query->field($itemsField)->with(
                        [
                            'product'=>function($query){
                                $query->field('id,is_on_sale');
                            }
                        ]
                    );
                }
            ]
        )->with(
            [
                'express'=>function($query){
                    $query->field('id,title name,code,type');
                }
            ]
        )->where($map)->order('create_time desc')->paginate($size, true, ['page' => $page]);
        $pagingData->visible($visibleField);
        $dataArr = $pagingData->toArray();
        $list = $dataArr['data'];
        self::getOrderList($list);
        $data = [
            'list' => $list,
            'page' => $dataArr['current_page'],
            'has_more' => $dataArr['has_more'],
        ];
        return $data;
    }
    public static function getOrderList(&$list){
        $orderService = new OrderService();
        foreach ($list as &$row){
            if($row['odd_number']){
                $row['express']['odd_number'] = $row['odd_number'];
                unset($row['express']['id']);
            }
            unset($row['odd_number']);
            foreach ($row['snap_items'] as &$snap_item){
                $snap_item['is_on_sale'] = $snap_item['product']['is_on_sale'];
                unset($snap_item['product']);
            }
            $row['is_allow_return'] = $orderService->getOrderIsAllowReturn($row['status'],$row['confirm_time'],$row['id']);
        }
    }
    public static function getSummaryByPage($page=1, $size=20){
        $pagingData = self::order('create_time desc')->paginate($size, true, ['page' => $page]);
        return $pagingData ;
    }


    public static function deleteOrder($id){
        $orderProductIds = model('OrderProduct')->where('order_id',$id)->column('id');
        $afterserviceIds = model('AfterService')->where('order_id',$id)->column('id');
        $afterserviceProductIds = model('AfterServiceProduct')
            ->where('after_service_id','in',$afterserviceIds)->column('id');
        Db::startTrans();
        try{
            self::destroy($id);
            OrderProduct::destroy($orderProductIds);
            AfterService::destroy($afterserviceIds);
            AfterserviceProduct::destroy($afterserviceProductIds);
            Db::commit();
            return RequestResponse::getResponse();
        }catch (Exception $e){
            Db::rollback();
            return RequestResponse::getResponse($e->getMessage(),'error',502);
        }
    }
}
