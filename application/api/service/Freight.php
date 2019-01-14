<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/8/6 0006
 * Time: 下午 4:47
 */

namespace app\api\service;

use app\api\model\FreightConfig;
use app\api\model\FreightRegion;
use app\api\model\FreightTemplate;
use app\api\model\Region;

class Freight
{
    protected $address = [];
    protected $oProducts = [];
    protected $products = [];

    public function setAddress($address){
        $this->address = $address;
    }

    public function setProducts($oProducts,$products){
        $this->oProducts = $oProducts;
        $this->products = $products;
    }

    public function calculateFreight(){
        $freight = 0;
        $productTemplateIds = [];
        $products = [];
        foreach ($this->products as $product){
            if($product['template_id']!=0 && $product['is_free_shipping']==0){
                array_push($productTemplateIds,$product['template_id']);
                array_push($products,$product);
            }
        }
        $this->products = $products;
        $templateIds = array_unique($productTemplateIds);
        if(!empty($templateIds)){
            foreach ($templateIds as $templateId){
                $totalUnit = $this->getTotalUnit($templateId);
                $freightConfig = $this->getFreightConfig($templateId);
                $freightPrice = $this->getFreightPrice($totalUnit,$freightConfig);
                $freight += $freightPrice;
            }
        }
        return $freight;
    }


    public function getTotalUnit($templateId){
        $total_unit = 0;
        for($i=0;$i<count($this->products);$i++){
            $product = $this->products[$i];
            $oProduct = $this->oProducts[$i];
            if($product['template_id']==$templateId && $product['is_free_shipping']==0){
                $template = FreightTemplate::get($templateId);
                if($template){
                    switch ($template['type']) {
                        case 1:
                            //按重量
                            $total_unit += $product['weight'] * $oProduct['count'];//总重量
                            break;
                        case 2:
                            //按体积
                            $total_unit += $product['volume'] * $oProduct['count'];//总体积
                            break;
                        default:
                            //按件数
                            $total_unit += $oProduct['count'];
                    }
                }
            }
        }
        return $total_unit;
    }
    /**
     * 根据总量和配置信息获取运费
     * @param $total_unit
     * @param $freight_config
     * @return mixed
     */
    private function getFreightPrice($total_unit,$freight_config){
        $total_unit = floatval($total_unit);
        if($total_unit > $freight_config['first_unit']){
            $average = ceil(($total_unit-$freight_config['first_unit']) / $freight_config['continue_unit']);
            $freight_price = $freight_config['first_money'] + $freight_config['continue_money'] * $average;
        }else{
            $freight_price = $freight_config['first_money'];
        }
        return $freight_price;
    }

    public function getFreightConfig($templateId=-1){
        $regionModel = new Region();
        $freightRegionModel = new FreightRegion();
        $countryId = $regionModel->where(['name'=>$this->address['country'],'level'=>3])->value('id');
        $configId = $freightRegionModel->where(['template_id'=>$templateId,'region_id'=>$countryId])->value('config_id');
        if(!$configId){
            $cityId = $regionModel->where(['name'=>$this->address['city'],'level'=>2])->value('id');
            $configId = $freightRegionModel->where(['template_id'=>$templateId,'region_id'=>$cityId])->value('config_id');
        }
        if(!$configId){
            $provinceId = $regionModel->where(['name'=>$this->address['province'],'level'=>1])->value('id');
            $configId = $freightRegionModel->where(['template_id'=>$templateId,'region_id'=>$provinceId])->value('config_id');
        }
        if(!$configId){
            $freightConfig = FreightConfig::where(['template_id'=>$templateId,'is_default'=>1])->find();
        }else{
            $freightConfig = FreightConfig::get($configId);
        }
        if($freightConfig){
            return $freightConfig->toArray();
        }
    }
}