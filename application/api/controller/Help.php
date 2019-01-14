<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/31 0031
 * Time: 上午 9:18
 */

namespace app\api\controller;

use app\api\model\HelpType;
use app\api\service\Token;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use app\common\response\RequestResponse;

class Help extends BaseController
{
    public function getCategory(){
        $list = HelpType::all();
        return RequestResponse::getResponse('','','',$list);
    }

    public function getList($id=-1,$page=1,$size=10){
        $idValidate = new IDMustBePositiveInt();
        $idValidate->checkUp();
        $pageValidate = new PagingParameter();
        $pageValidate->checkUp();
        $category = HelpType::get($id);
        if(!$category){
            return RequestResponse::getResponse('错误参数id','error',403);
        }
        $list = model('Help')->field(['id,title'])->where('type_id',$id)->order('create_time desc')->
        paginate($size,true,['page'=>$page]);
        $dataArr = $list->toArray();
        $data = [
            'category_title' =>$category['title'],
            'list' => $dataArr['data'],
            'page' => $dataArr['current_page'],
            'has_more' => $dataArr['has_more'],
        ];
        return RequestResponse::getResponse('','','',$data);
    }

    public function getDetail($id=-1){
        $validate = new IDMustBePositiveInt();
        $validate->checkUp();
        $data = model('Help')->field('type_id,id,update_time,recommend',true)->where('id',$id)->find();
        if(!$data){
            return RequestResponse::getResponse('错误参数id','error',403);
        }
        return RequestResponse::getResponse('','','',$data);
    }

    public function respond(){
        $data = input('post.');
        $help = model('Help')->where('id',$data['id'])->find();
        if(!$help){
            return RequestResponse::getResponse('错误参数id','error',403);
        }
        $uid = Token::getCurrentUid();
        $helpAction = model('HelpAction')->where(['user_id'=>$uid,'help_id'=>$data['id']])->find();
        if(!$helpAction){
            $helpData = [
                'user_id' => $uid,
                'help_id' => $help['id'],
            ];
            if($data['is_approve']){
                $help->tops = $help->tops +1 ;
            }else{
                $help->tread = $help->tread +1 ;
                $helpData['is_approve'] = 0;
            }
            model('HelpAction')->isUpdate(false)->save($helpData);
            $help->save();

        }
        return RequestResponse::getResponse('提交成功,感谢你的评价');
    }

    public function hot($size=10){
        $list = model('Help')->field('id,title')->where('recommend',1)->limit($size)->select();
        return RequestResponse::getResponse('','','',$list);
    }

}