<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/28
 * Time: 11:21
 */

namespace app\common\service;


final class TreeData
{
    public function getTreeData($data,$pid=0,$fieldPid='pid',$level=1){
        static $arr=array();
        foreach ($data as $k => $v) {
            if($v[$fieldPid]==$pid){
                $v['level']=$level;
                $v['dataid']=$this->getParentId($data,$v['id'],$fieldPid,true);
                $arr[]=$v;
                $this->getTreeData($data,$v['id'],$fieldPid,$level+1);
            }
        }
        return $arr;

    }
    public function getParentId($treeData,$id,$fieldPid,$clear=false){
        static $arr=array();
        if($clear){
            $arr=array();
        }
        foreach ($treeData as $k => $v) {
            if($v['id'] == $id){
                $arr[]=$v['id'];
                $this->getParentId($treeData,$v[$fieldPid],$fieldPid);
            }
        }
        asort($arr);
        $arrStr=implode('-', $arr);
        return $arrStr;
    }
    public function getHtmlData($data){
        foreach ($data as $k => $v) {
            $str = "";
            if ($v['level'] > 2) {
                for ($i = 1; $i < $v['level'] - 1; $i++) {
                    $str .= "&emsp;│";
                }
            }
            if ($v['level'] != 1) {
                if (isset($data[$k + 1]) && $data[$k + 1]['level'] >= $data[$k]['level']) {
                    $data[$k]['_title'] = $str . "&emsp;├─ ";
                } else {
                    $data[$k]['_title'] = $str . "&emsp;└─ ";
                }
            }else{
                $data[$k]['_title'] = '';
            }
        }
        return $data;
    }

    public function channelList($data,$pid=0,$fieldPid='pid',$level=1,$maxLevel=2){
        $arr=array();
        foreach ($data as $k => $v) {
            if($v[$fieldPid]==$pid){
                $arr[$v['id']]=$v;
                $level<$maxLevel && $arr[$v['id']]['childs']=$this->channelList($data,$v['id'],$fieldPid,$level+1);
            }
        }
        return $arr;
    }
}