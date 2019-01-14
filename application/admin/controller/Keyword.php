<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/24 0024
 * Time: 下午 5:22
 */

namespace app\admin\controller;

use app\admin\validate\BaseValidate;
use app\common\response\RequestResponse;

class Keyword extends BaseController
{
    public function index(){
        return $this->fetch();
    }

    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $list = model('Keyword')->order('id desc')->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'count' => $list['total'],
            'data' => $list['data'],
        ];
        return json($data);
    }

    public function add(){
        return $this->fetch();
    }
    public function saveAdd(){
        $post = input('post.');
        model('Keyword')->isUpdate(false)->save($post);
        return RequestResponse::getResponse();
    }
    public function del(){
        $id = input('post.id');
        $row = model('Keyword')->where('id',$id)->find();
        if(!$row){
            return RequestResponse::getResponse('错误参数id','error');
        }
        model('Keyword')->where('id',$id)->delete();
        return RequestResponse::getResponse();
    }
}