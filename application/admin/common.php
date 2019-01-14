<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/20 0020
 * Time: 上午 10:50
 */
function getEmpty($colspan,$msg='没有符合条件的数据'){
    $html= '<tr><td colspan="'.$colspan.'" style="text-align:center;">'.$msg.'</td></tr>';
    return $html;
}

function editBack($msg){
    $html = "<script>alert('{$msg}');history.go(-2);</script>";
    echo $html;
}