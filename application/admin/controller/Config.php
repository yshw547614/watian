<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/14 0014
 * Time: 上午 11:31
 */

namespace app\admin\controller;

use app\common\response\RequestResponse;
use app\common\service\JsonConfig;
use app\common\service\Images as ImgService;

class Config extends BaseController
{
    public function appWechat(){
        return $this->fetch('app_wechat/index');
    }
    public function getData(){
        $appHtml = JsonConfig::get('app_word.content');
        $wechatHtml = JsonConfig::get('wechat_word.content');
        $data = [
            'appHtml' => $appHtml,
            'wechatHtml' => $wechatHtml
        ];
        return $data;
    }
    public function saveData(){
        $post = input('post.');
        $appHtml = $post['appHtml'];
        $wechatHtml = $post['wechatHtml'];
        JsonConfig::set('app_word.content',$appHtml);
        JsonConfig::set('wechat_word.content',$wechatHtml);
        return RequestResponse::getResponse();
    }

    public function upload(){
        $imgService = new ImgService();
        $file = request()->file('file');
        $imgSavePath = config('images.images_save_path');
        $imgWebPath = config('images.images_web_path');
        $saveName = $imgService->uploadImg($file,$imgSavePath);
        $result = [
            'code' => 0,
            'msg' => '',
            'data' => [
                'title' => '',
                'src' => $imgWebPath.$saveName

            ]
        ];
        return $result;
    }

    public function SetWechatWord(){
        if(request()->isPost()){
            $content = input('post.content/s');
            JsonConfig::set('wechat_word.content',$content);
            $this->success('操作成功');
        }else{
            $content = JsonConfig::get('wechat_word.content');
            return $this->fetch('text',['type'=>'wechat','content'=>$content]);
        }
    }
    public function SetAppWord(){
        if(request()->isPost()){
            $content = input('post.content/s');
            JsonConfig::set('app_word.content',$content);
            $this->success('操作成功');
        }else{
            $content = JsonConfig::get('app_word.content');
            return $this->fetch('text',['type'=>'app','content'=>$content]);
        }
    }
}