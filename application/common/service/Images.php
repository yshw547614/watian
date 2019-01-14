<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/29 0029
 * Time: 上午 11:29
 */

namespace app\common\service;


class Images
{
    public function uploadImg($file,$savePath){
        $saveName = '';
        $info = $file->rule([$this,'fileRule'])->move($savePath);
        if($info){
            $saveName = $info->getSaveName();
            $this->imageCompress($savePath.$saveName);
        }
        return $saveName;
    }

    /**
     * desription 压缩图片
     * @param sting $imgsrc 图片路径
     * @param string $imgsrc 压缩后保存路径
     */
    public function imageCompress($imgsrc){
        list($width,$height,$type)=getimagesize($imgsrc);
        if($width>750){
            $new_width=750;
            $new_height=floor($new_width*$height/$width);
        }else{
            $new_width=$width;
            $new_height=$height;
        }
        switch($type){
            case 1:
                $giftype=$this->check_gifcartoon($imgsrc);
                if($giftype){
                    $image_wp=imagecreatetruecolor($new_width, $new_height);
                    $image = imagecreatefromgif($imgsrc);
                    imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    imagejpeg($image_wp, $imgsrc,75);
                    imagedestroy($image_wp);
                }
                break;
            case 2:
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefromjpeg($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($image_wp, $imgsrc,75);
                imagedestroy($image_wp);
                break;
            case 3:
                $image_wp=imagecreatetruecolor($new_width, $new_height);
                $image = imagecreatefrompng($imgsrc);
                imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                imagejpeg($image_wp, $imgsrc,75);
                imagedestroy($image_wp);
                break;
        }
    }
    /**
     * desription 判断是否gif动画
     * @param sting $image_file图片路径
     * @return boolean t 是 f 否
     */
    public function check_gifcartoon($image_file){
        $fp = fopen($image_file,'rb');
        $image_head = fread($fp,1024);
        fclose($fp);
        return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/",$image_head)?false:true;
    }
    public function fileRule(){
        $date = date('Ymd');
        $fileName = md5(uniqid());
        return $date.'/'.$fileName;
    }
    public function fileAbsolutePath($savePath,$saveName){
        $absolutePath = $savePath.$saveName;
        return $absolutePath;
    }

    public function deleteImg($thumbPath){
        $flag = false;
        file_exists($thumbPath) && $flag = @unlink($thumbPath);
        return $flag;
    }

    public function printdir($absolutePath,$relativePath)
    {
        static $files = [];
        //opendir() 打开目录句柄
        if($handle = @opendir($absolutePath)){
            //readdir()从目录句柄中（resource，之前由opendir()打开）读取条目,
            // 如果没有则返回false
            while(($file = readdir($handle)) !== false){//读取条目
                if( $file != ".." && $file != "."){//排除根目录
                    if(is_dir($absolutePath.$file)) {//如果file 是目录，则递归
                        $this->printdir($absolutePath .$file.'/',$relativePath.$file.'/');
                    }else{
                        //获取文件修改日期
                        $row['time'] = filemtime($absolutePath.$file);
                        $row['src'] = $relativePath.$file;
                        //文件修改时间作为健值
                        $files[] = $row;
                    }
                }
            }
            @closedir($handle);
        }

        return $files;
    }
    public function arraysort($files) {
        if( is_array($files)){
            ksort($files);
            $arr = [];
            foreach($files as $key => $value) {
                if (is_array($value)) {
                    $arr[$key] = $this->arraysort($value);
                } else {
                    $arr[$key] = $value;
                }
            }
            return $arr;
        } else {
            return $files;
        }
    }
    public function getImages($absolutePath,$relativePath,$files){
        static $result = [];
        foreach($files as $file) {
            if($file!= '.' && $file != '..') {
                if(is_dir($absolutePath.DS.$file)) {
                    $sonFileAbsolutePath = $absolutePath.$file.DS;
                    $sonFileRelativePath = $relativePath.$file.DS;
                    $sonFiles = scandir($sonFileAbsolutePath);
                    $this->getImages($sonFileAbsolutePath,$sonFileRelativePath,$sonFiles);
                } else {
                    $result[] = $relativePath.$file;
                }
            }
        }
        return $result;
    }

}