<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/27 0027
 * Time: 下午 3:20
 */

namespace app\admin\controller;

use app\admin\validate\BaseValidate;
use app\common\response\RequestResponse;
use app\common\service\JsonConfig;

class StoreAddress extends BaseController
{
    public function index(){
        return $this->fetch('shop_set/address');
    }
    public function getData(){
        $data = JsonConfig::get('store.receive');
        return $data;
    }
    public function saveData(){
        $post = input('post.');
        JsonConfig::set('store.receive',$post);
        return RequestResponse::getResponse();
    }
}