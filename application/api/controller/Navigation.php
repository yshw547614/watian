<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/27 0027
 * Time: 下午 12:51
 */

namespace app\api\controller;

use app\api\model\Navigation as NavigationModel;
use app\api\validate\PagingParameter;
use app\common\response\RequestResponse;

class Navigation extends BaseController
{
    public function getNav($size=10){
        $validate = new PagingParameter();
        $validate->checkUp();
        $navigationModel = new NavigationModel();
        $list = $navigationModel->limit($size)->select();
        if($list){
            $list->hidden(['id']);
            return RequestResponse::getResponse('','','',$list);
        }

    }
    public function getNavCategory($size=10){
        $datas = CategoryModel::where(['is_home_nav'=>1])->limit(9)->select();
        if($datas){
            $datas->hidden(['pid','is_home','is_home_nav','rank']);
        }
        foreach ($datas as &$data){
            $data['src'] = "pages/shop/product/comment?id=".$data['id'];
        }
        return RequestResponse::getResponse('','','',$datas);
    }
}