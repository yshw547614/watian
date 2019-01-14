<?php
/**

 * Date: 2017/2/15
 * Time: 13:40
 */

namespace app\api\controller;


use app\api\validate\IDMustBePositiveInt;
use app\api\model\Advert as AdvertModel;
use app\common\response\RequestResponse;

/**
 * Banner资源
 */ 
class Advert extends BaseController
{
    /**
     * 获取Banner信息
     * @url     /banner/:id
     * @http    get
     * @param   int $id banner id
     * @return  array of banner item , code 200
     */
    public function getAdvert($id)
    {
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $banner = AdvertModel::getAdvertById($id);
        if (!$banner ) {
            return RequestResponse::getResponse('请求广告不存在','error',403);
        }
        return RequestResponse::getResponse('','','',$banner);
    }

    public function getList(){
        $list = model('Advert')->select();
        return RequestResponse::getResponse('','','',$list);
    }
    public function getDetail($id=-1){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $advert = model('Advert')->field('name,description')->where('id',$id)->find();
        if(!$advert){
            return RequestResponse::getResponse('错误id参数','error',403);
        }
        $itmes = model('AdvertItem')->field('img_url,link')->where('advert_id',$id)->select();
        $advert['items'] = $itmes;
        return RequestResponse::getResponse('','','',$advert);
    }
}