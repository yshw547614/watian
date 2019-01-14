<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/20 0020
 * Time: 下午 5:28
 */

namespace app\api\controller;

use app\api\service\Token;
use app\api\model\UserCertificateProve;
use app\common\response\RequestResponse;

class Certificate extends BaseController
{
    public function getCertificate(){
        $certificates = UserCertificateProve::all()->hidden(['user_id'])->toArray();
        return $certificates;
    }
    public function add(){
        $data = input('post.');
        validate('Certificate')->checkUp();
		$uid = Token::getCurrentTokenVar('uid');
        $data['images'] = serialize($data['images']);
        $data['user_id'] = $uid;
        $result = UserCertificateProve::create($data);
        return RequestResponse::getResponseByResult($result);
    }
    public function edit(){
        $certificate = new UserCertificateProve();
        $data = input('post.');
        $result = $certificate->isUpdate()->saveAll($data);
        return RequestResponse::getResponseByResult($result);
    }

    public function uploadImg(){
        $model = new UserCertificateProve();
        return $model->change();
    }
    public function del($id){
        $model = new UserCertificateProve();
        return $model->del($id);
    }
    public function upDateRank(){
        $model = new UserCertificateProve();
        return $model->updateRank();
    }

}