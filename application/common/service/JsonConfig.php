<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/30 0030
 * Time: 下午 3:07
 */

namespace app\common\service;

use think\Exception;

class JsonConfig
{

    protected static $jsonPath = CONF_PATH.'json/';
    public static function get($param){
        $result = [];
        $arr = explode('.',$param);
        $count = count($arr);
        ($count > 3 || $count<1) && self::error();
        $fileName = $arr[0].'.json';
        $data = self::getJson($fileName);
        switch ($count){
            case 1:
                $result = $data;
                break;
            case 2:
                $result = array_key_exists($arr[1],$data)?$data[$arr[1]]:'';
                break;
            case 3:
                $result = array_key_exists($arr[2],$data[$arr[1]])?$data[$arr[1]][$arr[2]]:'';
                break;
            default:
                self::error();
        }
        return $result;
    }
    public static function set($param,$value){
        $arr = explode('.',$param);
        $count = count($arr);
        ($count > 3 || $count<1) && self::error();
        $fileName = $arr[0].'.json';
        $data = self::getJson($fileName);
        switch ($count){
            case 1:
                $data = $value;
                break;
            case 2:
                !array_key_exists($arr[1],$data) && self::error();
                $data[$arr[1]] = $value;
                break;
            case 3:
                !array_key_exists($arr[2],$data[$arr[1]]) && self::error();
                $data[$arr[1]][$arr[2]] = $value;
                break;
            default:
                self::error();
        }
        $json = json_encode($data);
        file_put_contents(self::$jsonPath.$fileName,$json);
    }

    public static function getJson($fileName){
        $filePath = self::$jsonPath.$fileName;
        !file_exists($filePath) && self::error();
        $json = file_get_contents($filePath);
        $data = json_decode($json,true);
        return $data;
    }
    private static function error(){
        throw new Exception('参数错误');
    }

}