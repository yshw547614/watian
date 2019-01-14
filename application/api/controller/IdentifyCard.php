<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/27 0027
 * Time: 下午 5:08
 */

namespace app\api\controller;
use app\api\model\IdentifyCard as IdentifyCardModel;
use app\api\service\Token;
use app\api\validate\Identify;
use app\api\validate\IDMustBePositiveInt;
use app\common\response\RequestResponse;

class IdentifyCard extends BaseController
{
    public function handle(){
        $uid = Token::getCurrentTokenVar('uid');
        $data = input('post.');
        $isUpdate = isset($data['id'])?true:false;
        $validate = new Identify();
        $validate->checkUp();
        $data['user_id'] = $uid;
        if($isUpdate){
            $identifyCard = model('IdentifyCard')->where(['user_id'=>$uid,'id'=>$data['id']])->find();
            if(!$identifyCard){
                return RequestResponse::getResponse('错误id参数','error',403);
            }
            $result = IdentifyCardModel::update($data);
        }else{
            $result = IdentifyCardModel::create($data);
        }
        return RequestResponse::getResponseByResult($result);
    }

    public function getOne($id = -1){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $uid = Token::getCurrentTokenVar('uid');
        $data = model('IdentifyCard')->where(['user_id'=>$uid,'id'=>$id])->find();
        if($data){
            $data->hidden(['user_id']);
            return RequestResponse::getResponse('','','',$data);
        }else{
            return RequestResponse::getResponse('错误id参数','error',403);
        }
    }

    public function getAll(){
        $uid = Token::getCurrentTokenVar('uid');
        $list = model('IdentifyCard')->where('user_id',$uid)->select();
        if($list){
            $list->hidden(['user_id']);
            return RequestResponse::getResponse('','','',$list);
        }else{
            return RequestResponse::getResponse('用户还没有添加用户信息','error',403);
        }
    }
    public function del($id=-1){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $uid = Token::getCurrentTokenVar('uid');
        $data = model('IdentifyCard')->where(['user_id'=>$uid,'id'=>$id])->find();
        if(!$data){
            return RequestResponse::getResponse('错误参数id','error',403);
        }
        if(IdentifyCardModel::destroy($id)){
            return RequestResponse::getResponse();
        }else{
            return RequestResponse::getResponse('删除失败','error',502);
        }
    }

    public function setDefault($id=-1){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $uid = Token::getCurrentTokenVar('uid');
        $data = model('IdentifyCard')->where(['user_id'=>$uid,'id'=>$id])->find();
        if(!$data){
            return RequestResponse::getResponse('错误参数','error',403);
        }
        $data->is_default = 1;
        $data->save();
        model('IdentifyCard')->where('user_id',$uid)->where('id','neq',$data->id)->update(['is_default'=>0]);
        return RequestResponse::getResponse();
    }

    public function getDefault(){
        $uid = Token::getCurrentUid();
        $data = model('IdentifyCard')->field('id,name,id_number,obverse_img,opposite_img')
            ->where(['user_id'=>$uid,'is_default'=>1])->find();
        $data['id_number'] = $this->hideIdNumber($data['id_number']);
        return RequestResponse::getResponse('','','',$data);
    }
    public function hideIdNumber($id_number){
        $length = strlen($id_number);
        $startStr = substr($id_number,0,4);
        $endStr = substr($id_number,-4);
        $middleStr = str_repeat('*',$length-8);
        $str = $startStr.$middleStr.$endStr;
        return $str;
    }
}