<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/12
 * Time: 23:37
 */

namespace app\admin\service;

use app\admin\model\FreightConfig;
use app\admin\model\FreightRegion;
use app\admin\model\FreightTemplate;
use app\admin\validate\Freight as FreightValidate;

class Freight
{
    public function getTemplates(){
        $freightTemplate = new FreightTemplate();
        $temlates = $freightTemplate->with('config,config.region')->select();
        return $temlates;
    }
    public function getTemplateById($id){
        $freightTemplate = new FreightTemplate();
        $data = $freightTemplate->where('id',$id)->with('config,config.region')->find();
        return $data;
    }
    public function templateHandle(){
        $flag = false;
        $data = input('post.');
        $validate = new FreightValidate();
        $validate->checkData($data);
        $isUpdate = isset($data['id'])?true:false;
        $templateArr = ['name','type','is_enable_default'];
        $freightTemplate = new FreightTemplate();
        if($isUpdate){
            $template = $freightTemplate->isHasRecord($data['id']);
            array_unshift($templateArr,'id');
        }
        $template_data = $this->getTemplateData($templateArr,$data);
        $freightTemplate->isUpdate($isUpdate)->save($template_data);
        $templateId = $freightTemplate->id;
        if($isUpdate){
            $templateId = $templateId ? $templateId : $template['id'];
            $template_data['is_enable_default'] == 0 && $this->delConfigDefault($templateId);
        }
        $configs = $this->configHandle($data,$templateId,$isUpdate);
        $configIds = array_column($configs->toArray(),'id');
        $regions = $this->regionHandle($data['area_ids'],$templateId,$configIds);
        ($templateId || $configs || $regions) && $flag = true;
        return $flag;
    }
    public function configHandle($data,$templateId,$isUpdate){
        $freightConfig = new FreightConfig();
        $configs = [];
        $configIds = [];
        $result = [];
        for($i=0;$i<count($data['first_unit']);$i++){
            $config = [];
            if($isUpdate && isset($data['config_id'][$i])){
                $config['id'] = $data['config_id'][$i];
                array_push($configIds,$config['id']);
            }
            $config['first_unit'] = $data['first_unit'][$i];
            $config['first_money'] = $data['first_money'][$i];
            $config['continue_unit'] = $data['continue_unit'][$i];
            $config['continue_money'] = $data['continue_money'][$i];
            $config['template_id'] = $templateId;
            $config['is_default'] = $data['area_ids'][$i]?0:1;
            array_push($configs,$config);

        }
        if(!empty($configIds)){
            $freightConfig->where('template_id',$templateId)->where('id','not in',$configIds)->delete();
        }
        if(!empty($configs)){
            $result = $freightConfig->saveAll($configs);
        }
        return $result;
    }
    public function regionHandle($areaIds,$templateId,$configIds){
        $regions = [];
        $result = [];
        $freightRegion = new FreightRegion();
        for ($i=0;$i<count($configIds);$i++){
            if($areaIds[$i]){
                $areaIdArr = explode(',',$areaIds[$i]);
                foreach ($areaIdArr as $areaIdOne){
                    $region = [];
                    $region['template_id'] = $templateId;
                    $region['config_id'] = $configIds[$i];
                    $region['region_id'] = $areaIdOne;
                    array_push($regions,$region);
                }
            }
        }
        if(!empty($regions)){
            $freightRegion->where('template_id',$templateId)->where('config_id','in',$configIds)->delete();
            $result = $freightRegion->saveAll($regions);
        }
        return $result;
    }
    public function delConfigDefault($templateId){
        $freightConfig = new FreightConfig();
        $freightConfig->where(['template_id'=>$templateId,'is_default'=>1])->delete();
    }
    public function delete($id){
        $flag = false;
        $freightTemplate = new FreightTemplate();
        $freightConfig = new FreightConfig();
        $freightRegion = new FreightRegion();
        $freightTemplate->isHasRecord($id);
        $configIds = $freightConfig->where('template_id',$id)->column('id');
        $freightTemplate->where('id',$id)->delete() && $flag = true;
        $freightConfig->where('id','in',$configIds)->delete() && $flag = true;
        $freightRegion->where('template_id',$id)->where('config_id','in',$configIds)->delete() && $flag = true;
        return $flag;
    }
    public function getTemplateData($arr,&$data){
        $result = [];
        foreach ($arr as $value){
            $result[$value] = $data[$value];
            unset($data[$value]);
        }
        return $result;
    }
    public function getArea($data){
        $areaIds = $selectArea = [];
        if(isset($data['config']) && is_array($data['config'])){
            foreach ($data['config'] as &$config){
                if(!empty($config['region']) && is_array($config['region'])){
                    foreach ($config['region'] as $region){
                        array_push($areaIds,$region['id']);
                        array_push($selectArea,$region['name']);
                    }
                    unset($config['region']);
                    $config['areaId'] = implode(',',$areaIds);
                    $config['selectArea'] = implode(',',$selectArea);
                }else{
                    unset($config['region']);
                    $config['areaId'] = '';
                    $config['selectArea'] = '中国';
                }
            }
        }
        return $data;
    }
}