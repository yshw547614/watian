<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/4/26 0026
 * Time: 下午 5:14
 */

namespace app\admin\model;

use app\common\service\TreeData;
use app\common\service\Images;
use think\Exception;
use think\Model;
use traits\controller\Jump;

class BaseModel extends Model
{
    use Jump;

    public function isHasNewData($postData,$dbDate,$isAjax=false){
        $flag = false;
        foreach ($postData as $k => $v){
            if($v != $dbDate[$k]){
                $flag = true;
            }
        }
        if($flag){
            return true;
        }else{
            $this->error('没有数据更新');
        }

    }

    public function isHasRecord($condition,$tipsMsg='请求的数据不存在',$isAjax=false){
        $record = $this::get($condition);
        if($record){
            return $record;
        }else{
            if($isAjax){
                return new Exception($tipsMsg,403);
            }else{
                $this->error($tipsMsg);
            }
        }
    }

    public function addRecord($data,$url,$actionMsg,$relation=false){
        $result = $this->isUpdate(false)->save($data);
        if($result){
            $this->success('添加'.$actionMsg.'成功',$url);
        }else{
            $exception = new Exception('添加'.$actionMsg.'失败');
            throw $exception;
        }
    }

    public function updateRecord($data,$url,$actionMsg,$allowFiled=true){
        $result = $this->allowField($allowFiled)->isUpdate(true)->save($data);
        if($result){
            $this->success($actionMsg.'更改成功',$url);
        }else{
            $exception = new Exception($actionMsg.'更新失败');
            throw $exception;
        }

    }
    public function delRecord($ids,$isTrue=false){
        $result = $this::destroy($ids,$isTrue);
        if($result){
            $this->success('数据已经删除');
        }else{
            $exception = new Exception('数据删除失败');
            throw $exception;
        }
    }

    public function isUnique($condition,$actionMsg="数据",$isAjax=false){
        $result = $this::get($condition);
        if($result){
            if($isAjax){
                return false;
            }else{
                $this->error($actionMsg.'已经存在');
            }
        }else{
            return true;
        }
    }

    public function numericArray($data,$key){
        $arr = [];
        foreach ($data as $value){
            $arr[] = $value[$key];
        }
        return $arr;
    }
    public function getTreeResult($order,$fieldPid){
        // 判断是否需要排序
        if(empty($order)){
            $data=$this::all()->toArray();
        }else{
            $data=$this->order($order.' is null,'.$order)->select()->toArray();
        }
        $dataModel = new TreeData();
        $treeData = $dataModel->getTreeData($data,0,$fieldPid);
        $treeRules = $dataModel->getHtmlData($treeData);
        return $treeRules;
    }

    public function addThumb($file,$imgUploadPath){
        $image = new Images();
        $saveName = $image->uploadImg($file,$imgUploadPath);
        return $saveName;
    }
    public function updataThumb($file,$oldThumbImg,$imgUploadPath){
        $image = new Images();
        $image->deleteImg($imgUploadPath.$oldThumbImg);
        $saveName = $image->uploadImg($file,$imgUploadPath);
        return $saveName;
    }
}