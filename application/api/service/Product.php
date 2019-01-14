<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/9 0009
 * Time: 上午 9:46
 */

namespace app\api\service;
use app\common\response\RequestResponse;
use think\Exception;

class Product
{
    static public function getProducts($oProducts,$dProducts){
        $products = [];
        foreach ($oProducts as $oProduct){
            $oPid = $oProduct['product_id'];
            $isHas = false;
            foreach ($dProducts as $dProduct){
                if($oPid == $dProduct['id']){
                    array_push($products,$dProduct);
                    $isHas = true;
                    continue;
                }
            }
            if(!$isHas){
                throw new Exception('id为' . $oPid . '的商品不存在',403);
            }
        }
        return $products;
    }
}