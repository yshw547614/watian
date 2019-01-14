<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 下午 5:40
 */

namespace app\admin\controller;

use app\common\service\AccessToken;
use app\common\service\Refund;

class Index extends BaseController
{
    public function index(){
        return view();
    }

    public function main(){
        return $this->fetch();
    }

    public function test(){
        $rows = model('OrderProduct')->field('id,product_id,thumb_img')->select()->toArray();
        foreach ($rows as &$row){
            $thumb_img = model('Product')->where('id',$row['product_id'])->value('thumb_img');
            $row['thumb_img'] = $thumb_img;
        }
        //print_r($rows);
        model('OrderProduct')->isUpdate(true)->saveAll($rows);
    }
}