<?php
/**

 * Date: 2017/2/26
 * Time: 14:15
 */

namespace app\api\controller;

use app\api\service\Pay as PayService;
use app\api\service\WxNotify;
use app\common\response\RequestResponse;

class Pay extends BaseController
{
    public function getPreOrder()
    {
        $post = input('post.');
        $orderIds = $post['id'];
        if(!is_array($orderIds)){
            return RequestResponse::getResponse('请提供正确参数','error',403);
        }
        foreach ($orderIds as $orderId){
            if(!preg_match("/^[1-9][0-9]*$/",$orderId)){
                return RequestResponse::getResponse('请提供正确参数','error',403);
            }
        }
        $pay= new PayService($orderIds);
        return $pay->pay();
    }

    public function redirectNotify()
    {
        $notify = new WxNotify();
        $notify->handle();
    }

    public function notifyConcurrency()
    {
        $notify = new WxNotify();
        $notify->handle();
    }
    
    public function receiveNotify()
    {
          $notify = new WxNotify();
          $notify->Handle();
    }
}