<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/15
 * Time: 13:39
 */

namespace app\common\enum;

class OrderApplyBack{
    //所有商品无售后
    const NONEAPPLYBACK = 1;

    //部分商品有售后
    const SOMEAPPLYBACK = 2;

    //全部商品有售后
    const ALLAPPLYBACK = 3;

    //拒绝所有售后申请
    const NONEREFUND = 4;

    //拒绝部分售后申请
    const SOMEREFUND = 5;

    //同意所有售后申请
    const ALLREFUND = 6;
}