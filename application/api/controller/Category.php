<?php
/**

 * Date: 2017/2/19
 * Time: 11:28
 */

namespace app\api\controller;

use app\api\model\Category as CategoryModel;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use app\common\response\RequestResponse;


class Category extends BaseController
{
    /**
     * 获取所有顶级类目
     * @return array of Categories
     */

    public function getTopCategories(){
        $categories = model('Category')->field('id,name')->where('pid',0)->select();
        return RequestResponse::getResponse('','','',$categories);
    }

    public function getCategories($id,$size=3)
    {
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $data = model('Category')->field('id,advert_id,name')->where('id',$id)->find();
        if(!$data){
            return RequestResponse::getResponse('错误参数id','error',403);
        }
        $recommend = model('Category')->field('id,name,topic_img')
            ->where(['pid'=>$data['id'],'is_home'=>1])->order('create_time desc')
            ->limit($size)->select();
        $data['recommend'] = $recommend;
        $adverts = model('AdvertItem')->field('img_url,link')
            ->where('advert_id',$data['advert_id'])->select();
        $data['advert'] = $adverts;
        $categories = model('Category')->field('id,topic_img,name')->where('pid',$id)
            ->order('create_time desc')->select();
        $data['categories'] = $categories;
        $data->hidden(['advert_id']);
        return RequestResponse::getResponse('','','',$data);
    }
    public function getHomeCategory($size=10){
        $model = new CategoryModel();
        $validate = new PagingParameter();
        $validate->checkUp();
        $list = $model->getHomeCategorys($size);
        return RequestResponse::getResponse('','','',$list);
    }
}