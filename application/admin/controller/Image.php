<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/11/5 0005
 * Time: 下午 7:10
 */

namespace app\admin\controller;

use app\common\service\Images as ImgService;

class Image extends BaseController
{
    public function index(){
        return $this->fetch();
    }
    public function select(){
        $imgService = new ImgService();
        $page = request()->param('page');
        $limit = request()->param('limit');
        $absolutePath = config('images.images_save_path');
        $relativePath = config('images.images_web_path');
        $files = $imgService->printdir($absolutePath,$relativePath);
        $time = array_column($files,'time');
        array_multisort($time,SORT_DESC,$files);
        $images = array_column($files,'src');
        unset($files);
        $count = count($images);
        $start=($page-1)*$limit;
        $imgs = array_slice($images,$start,$limit);
        $result = [];
        foreach ($imgs as $img){
            $tmp['src'] = $img;
            $tmp['thumb'] = $img;
            array_push($result,$tmp);
        }
        $data = [
            'title' => '图片管理',
            'id' => 'Images',
            'count'=>$count,
            "data" => $result
        ];
        return json($data);
    }

    public function upload(){
        $imgService = new ImgService();
        $file = request()->file('file');
        $imgSavePath = config('images.images_save_path');
        $imgWebPath = config('images.images_web_path');
        $saveName = $imgService->uploadImg($file,$imgSavePath);
        $reubfo['code']= 0;
        $reubfo['savename'] = $imgWebPath.$saveName;
        return $reubfo;
    }
}