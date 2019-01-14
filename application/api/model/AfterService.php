<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/5 0005
 * Time: 上午 10:27
 */

namespace app\api\model;

use app\api\service\Token;
use app\common\enum\ReturnStatusEnum;
use app\common\model\AfterService as AfterServiceCommon;

class AfterService extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;
    protected $hidden = ['order_product_id','user_id'];

    use AfterServiceCommon;
    public function getRefundTypeAttr($value){
        $status = [
            '0' => '支付原路返回',
        ];
        return $status[$value];
    }

    public function setImagesAttr($value){
        if(!empty($value)){
            return serialize($value);
        }
    }
    public function createAfterService($orderId,$totalPrice,$status_remark){
        $uid = Token::getCurrentUid();
        $order = model('Order')->get($orderId);
        $afterServiceData = [
            'user_id' => $uid,
            'order_id' => $orderId,
            'order_no' => $order['order_no'],
            'status' => $status_remark['status'],
            'refund_money' => $totalPrice,
            'out_refund_no' =>md5(uniqid()),
            'remark' => $status_remark['remark']
        ];
        $afterService = self::create($afterServiceData);
        return $afterService;
    }
    public function createAfterServiceProduct($postDatas,$dbDatas,$afterServiceId){

        foreach ($postDatas as &$postData){
            foreach ($dbDatas as $dbData){
                if($postData['order_product_id'] == $dbData['id']){
                    $postData['amount'] = $dbData['count'];
                    $postData['after_service_id'] = $afterServiceId;
                }
            }
        }
        model('AfterServiceProduct')->saveAll($postDatas);
    }

    public function checkPostOrderProduct($datas){
        $flag = true;
        $reason_checked = model('ReturnSet')->column('reason_num');
        foreach ($datas as $data){
            if(!in_array($data['reason'],$reason_checked) ){
                $flag = false;
                break;
            }
        }
        $submit_notice = "请等待卖家审核通过,即可进入下一环节";
        $time = config('return.delivery_delay_time');
        $dateTime = date('m月d日 H:i',$time);
        $through_notice = '请您在'.$dateTime.'前将商品按如下地址寄回，逾期将自动取消申请';
        $result['status'] = $flag?ReturnStatusEnum::THROUGH:ReturnStatusEnum::SUBMIT;
        $result['remark'] = $flag?$through_notice:$submit_notice;
        return $result;
    }
}