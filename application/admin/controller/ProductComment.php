<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/16 0016
 * Time: 下午 2:44
 */

namespace app\admin\controller;

use app\admin\model\ProductComment as ProductCommentModel;
use app\admin\model\ProductCommentReply;
use app\admin\validate\BaseValidate;
use app\common\response\RequestResponse;

class ProductComment extends BaseController
{
    public function index(){
        $productCommentModel = new ProductCommentModel();
        $list = $productCommentModel->with(['product'=>function($query){
            $query->field('id,name');
        }])->paginate(9);
        $page = $list->render();
        return $this->fetch('index',['list'=>$list,'page'=>$page]);
    }

    public function getList(){
        $param = request()->param();
        $limit = $param['limit'];
        $isPass = $param['is_pass'];
        $list = model('ProductComment')->with(['product'=>function($query){
            $query->field('id,name');
        }])->where(['is_pass'=>$isPass])->paginate($limit)->toArray();

        $dataRows = $list['data'];
        foreach ($dataRows as &$dataRow){
            $dataRow['product_name'] = $dataRow['product']['name'];
            unset($dataRow['product']);
        }
        $data = [
            'code' => 0,
            'msg' => 'ok',
            'is_pass' => $isPass,
            'count' => $list['total'],
            'data' => $dataRows,
        ];
        return json($data);
    }
    public function updateIsPass(){
        $data = input('post.');
        model('ProductComment')->isUpdate(true)->save($data);
        $result = RequestResponse::getResponse();
        return json($result);
    }
    public function detail($id){
        $comment = ProductCommentModel::where('id',$id)->with(['user'=>function($query){
            $query->field('id,nickname,head_img');
        }])->with('reply')->find();
        if(!$comment){
            $this->error('错误id参数');
        }
        return $this->fetch('detail',['data'=>$comment]);
    }
    public function check(){
        $data = input('post.');
        $rule = [
            'id' => 'require|isPositiveInteger',
            'is_pass' => 'require|in:-1,0,1'
        ];
        $validate = new BaseValidate($rule);
        $validate->checkData($data,true);
        $comment = ProductCommentModel::get($data['id']);
        if(!$comment){
            return RequestResponse::getResponse('错误id参数','error',400);
        }
        if($comment->is_pass == $data['is_pass']){
            return RequestResponse::getResponse('请勿重复操作','error',402);
        }
        $comment->is_pass = $data['is_pass'];
        $comment->save();
        return RequestResponse::getResponse('操作成功');
    }

    public function reply(){
        $data = input('post.');
        $rule = [
            'product_comment_id' => 'require|isPositiveInteger',
            'content' => 'require|isNotEmpty'
        ];
        $validate = new BaseValidate($rule);
        if(!$validate->checkData($data,true)){
            return RequestResponse::getResponse($validate->getError(),'error',403);
        }
        $productCommentReply = ProductCommentReply::where('product_comment_id',$data['product_comment_id'])->find();
        if($productCommentReply){
            $productCommentReply->content = $data['content'];
            $result = $productCommentReply->save();
        }else{
            $result = ProductCommentReply::create($data);
        }
        if($result){
            return RequestResponse::getResponse('回复成功');
        }else{
            return RequestResponse::getResponse('回复失败','error',502);
        }
    }
    public function delete($id){

    }
}