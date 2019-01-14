<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/25
 * Time: 1:28
 */

namespace app\api\controller;


use app\api\validate\BaseValidate;
use app\common\response\RequestResponse;
use think\Exception;

class Express extends BaseController
{
    public function getExpress(){
        $list = model('Express')->select();
        return RequestResponse::getResponse('','','',$list);
    }

    public function getInternationalExpress($odd_number=''){
        $rule = [
            'odd_number' => 'require'
        ];
        $vilidate = new BaseValidate($rule,['odd_number.require'=>'请提供物流单号']);
        $vilidate->checkUp();
        $oddNum = $odd_number;
        $express = model('InternationalExpress')->where(['odd_number'=>$oddNum])->value('info');
        if(!$express){
            $url = 'http://pswltrack.szmsd.com:23350/kpsd_track_web/trackForJson.action?billcode='.$oddNum;
            $express = curl_get($url);
            if(!$express){
                throw new Exception('没有查询到此快递单号的物流信息',406);
            }
            $data['odd_number'] = $oddNum;
            $data['info'] = $express;
            model('InternationalExpress')->save($data);
        }
        $expressArr = json_decode($express);
        $details = $expressArr->result->traces->details;
        if($details){
            $data = [];
            foreach ($details as $detail){
                $row['context'] = $detail->acceptAddress;
                $row['time'] = $detail->acceptTime;
                array_push($data,$row);
            }
            return RequestResponse::getResponse('','','',$data);
        }else{
            return RequestResponse::getResponse('暂无物流信息','error',406);
        }


    }
}