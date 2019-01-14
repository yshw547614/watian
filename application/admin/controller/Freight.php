<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/3
 * Time: 18:58
 */

namespace app\admin\controller;

use app\admin\service\Freight as FreightService;
use app\admin\model\Region;
use app\admin\validate\IdMustBePositiveInt;
use app\common\response\RequestResponse;
use app\common\service\JsonConfig;
use think\Log;

class Freight extends BaseController
{
    public function index(){
        $freightFree = JsonConfig::get('store.freight_free');
        $freightService = new FreightService();
        $list = $freightService->getTemplates();
        return $this->fetch('index',['list'=>$list,'freight_free'=>$freightFree]);
    }
    public function freight(){
        return $this->fetch();
    }
    public function getTemplate(){
        $param = request()->param();
        $row = model('FreightTemplate')->where('id',$param['id'])->find()->toArray();
        return json($row);
    }
    public function getConfig(){
        $param = request()->param();
        $rows = model('FreightConfig')->with('region')->where('template_id',$param['template_id'])
            ->select()->toArray();
        foreach($rows as &$row){
            $row['area_ids'] = implode(',',array_column($row['region'],'id'));
            $row['area_names'] = implode(',',array_column($row['region'],'name'));
            unset($row['region']);
        }
        return json($rows);

    }
    public function saveData(){
        $model = model('FreightTemplate');
        $post = input('post.');
        $isUpdate = isset($post['id']) ? true : false;
        $data = [
            'name' => $post['name'],
            'is_enable_default' => $post['is_enable_default'] == 'on' ? 1 : 0,
            'type' => $post['type']
        ];
        if($isUpdate){
            $data['id'] = $post['id'];
        }
        $model->isUpdate($isUpdate)->save($data);
        $this->updateConfig(array_values($post['template']),$model->id);
        $result = RequestResponse::getResponse();
        return json($result);
    }
    public function updateConfig($postConfigs,$templateId){
        $postRegions = array_column($postConfigs,'area_ids');
        foreach ($postConfigs as &$postConfig){
            if(isset($postConfig['config_id'])){
                $postConfig['id'] = $postConfig['config_id'];
            }
            $postConfig['template_id'] = $templateId;
            unset($postConfig['config_id']);
            unset($postConfig['area_ids']);
        }
        $total = model('FreightConfig')->where('template_id',$templateId)->count();
        $configIds = array_column($postConfigs,'id');
        $count = count($configIds);
        if($count<$total){
            model('FreightConfig')->where('id','not in',$configIds)->delete();
        }
        $configs = model('FreightConfig')->saveAll($postConfigs);
        $configIds = array_column($configs->toArray(),'id');
        $this->updateRegion($postRegions,$configIds,$templateId);
    }
    public function updateRegion($postRegions,$configIds,$templateId){
        $regions = [];
        for ($i=0;$i<count($configIds);$i++){
            if($postRegions[$i]){
                $areaIdArr = explode(',',$postRegions[$i]);
                foreach ($areaIdArr as $areaIdOne){
                    $region = [];
                    $region['template_id'] = $templateId;
                    $region['config_id'] = $configIds[$i];
                    $region['region_id'] = $areaIdOne;
                    array_push($regions,$region);
                }
            }
        }
        model('FreightRegion')->where('config_id','in',$configIds)
            ->where('template_id',$templateId)->delete();
        model('FreightRegion')->saveAll($regions);
    }
    public function add(){
        $freightService = new FreightService();
        if(request()->isPost()){
            $flag = $freightService->templateHandle();
            if($flag){
                $this->success('添加模板成功',url('index'));
            }else{
                $this->error('添加模板失败');
            }
        }else{
            return $this->fetch('freight',['type'=>'add']);
        }
    }


    public function edit($id=-1){
        $freightService = new FreightService();
        if(request()->isPost()){
            $flag = $freightService->templateHandle();
            if($flag){
                $this->success('编辑模板成功',url('index'));
            }else{
                $this->error('编辑模板失败');
            }
        }else{
            $data = $freightService->getTemplateById($id);
            if(!$data){
                $this->error('错误参数id');
            }else{
                $data = $data->toArray();
            }
            $data = $freightService->getArea($data);
            return $this->fetch('freight',['type'=>'edit','data'=>$data]);
        }
    }

    public function del($id = -1){
        $validate = new IdMustBePositiveInt();
        $validate->checkData(['id'=>$id]);
        $freightService = new FreightService();
        $flag = $freightService->delete($id);
        if($flag){
            $this->success('模板删除成功');
        }else{
            $this->error('模板删除失败');
        }
    }

    public function area(){
        $provinceList = Region::where('parent_id',0)->select();
        return $this->fetch('area',['province_list'=>$provinceList]);
    }
    public function getRegion($level=1,$parent_id=0){
        $list = Region::where('level',$level)->where('parent_id',$parent_id)->select();
        $html = '';
        if($list){
            foreach($list as $h){
                $html .= "<option value='{$h['id']}'>{$h['name']}</option>";
            }
        }
        return $html;
    }
}