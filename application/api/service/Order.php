<?php
/**

 * Date: 2017/2/23
 * Time: 1:48
 */

namespace app\api\service;


use app\common\service\Refund;
use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\service\Product as ProductService;
use app\api\model\Order as OrderModel;
use app\api\model\UserAddress;
use app\common\enum\OrderStatusEnum;
use app\common\response\RequestResponse;
use think\Exception;

/**
 * 订单类
 * 订单做了以下简化：
 * 创建订单时会检测库存量，但并不会预扣除库存量，因为这需要队列支持
 * 未支付的订单再次支付时可能会出现库存不足的情况
 * 所以，项目采用3次检测
 * 1. 创建订单时检测库存
 * 2. 支付前检测库存
 * 3. 支付成功后检测库存
 */
class Order
{
    protected $oProducts;
    protected $products;
    protected $uid;
    protected $pOrder;

    function __construct()
    {
    }

    public function splitOrder(){
        $post = input('post.');
        $oProducts = $post['products'];
        $this->setProducts($oProducts);
        unset($post['products']);
        $this->pOrder = $post;
        $this->checkProduct();
        return $this->splitOrderProudct();

    }
    public function splitOrderProudct(){
        $internal = $external = $result = [];
        for($i=0;$i<count($this->oProducts);$i++) {
            $product = $this->products[$i];
            $oProduct = $this->oProducts[$i];
            if($product['nation']==1){
                array_push($internal,$oProduct);
            }else{
                array_push($external,$oProduct);
            }
        }
        if(!empty($internal)){
            $internalRsult = $this->place($internal);
            $result['list'][] = $internalRsult;
        }
        if(!empty($external)){
            $externalResult = $this->place($external);
            $result['list'][] = $externalResult;
        }
        $result['pass'] = true;
        return $result;
    }
    public function place($oProducts)
    {
        $this->setUid();
        $this->setProducts($oProducts);
        $snap = $this->getOrderStatus();
        $result = self::createOrderByTrans($snap);
        $this->reduceStock();
        return $result;
    }
    public function calculateOrderPrice(){
        $this->setUid();
        $data = input('post.');
        $oProducts = $data['products'];
        $this->setProducts($oProducts);
        $order = $this->getOrderStatus();
        return RequestResponse::getResponse('','','',$order);
    }

    public function setUid(){
        $uid = Token::getCurrentUid();
        $this->uid = $uid;
    }

    public function get_oProducts($orderID){
        $oProducts = OrderProduct::where('order_id', '=', $orderID)->select();
        return $oProducts;
    }
    public function setProducts($oProducts){

        $this->oProducts = $oProducts;
        $products = $this->getProducts();
        $this->products = $products;
    }

    private function getProducts(){
        $dProducts = $this->getProductsByOrder($this->oProducts);
        $products = ProductService::getProducts($this->oProducts,$dProducts);
        return $products;
    }
    public function checkProduct(){
        for($i=0;$i<count($this->oProducts);$i++){
            $product = $this->products[$i];
            $oProduct = $this->oProducts[$i];
            if($product['nation']==1){
                if(!isset($this->pOrder['identify_card_id']) or empty($this->pOrder['identify_card_id'])){
                    throw new Exception('海外产品必须提供身份证',408);
                }
            }
            if($product['is_on_sale']==0){
                throw new Exception('您选择的'.$product['name'].'商品已经下架',406);
            }
            if($product['stock']<=0 || ($product['stock'] - $oProduct['count'])<0){
                throw new Exception('您选择的'.$product['name'].'商品库存不足',405);
            }
        }
    }

    public function getOrderStatus()
    {
        $isFreeShipping = true;
        $status = [
            'orderPrice' => 0,//实付款金额
            'shippingPrice' => 0,
            'totalCount' => 0,
            'totalPrice' =>0,//订单总价
            'productPrice'=>0,
            'delivery_type' => '国内快递物流'
        ];
        for ($i=0;$i<count($this->oProducts);$i++){
            $product = $this->products[$i];
            $oProduct = $this->oProducts[$i];
            if($product['nation']==1){
                $status['delivery_type'] = '国内快递物流 + 国际快递物流';
            }
            if($product['is_free_shipping'] == 0){
                $isFreeShipping = false;
            }
            $status['totalCount'] += $oProduct['count'];
            $status['productPrice'] += $product['price']*$oProduct['count'];
        }
        if($isFreeShipping){
            $status['shippingPrice'] = 0;
        }else{
            $status['shippingPrice'] = $this->getFreight($status['productPrice'],$status['totalCount']);
        }
        $status['totalPrice'] = $status['productPrice'] + $status['shippingPrice'];
        $status['orderPrice'] = $status['productPrice'] + $status['shippingPrice'];
        return $status;
    }


    private function getFreight($totalPrice,$totalCount){
        $is_free = $this->isFreightFree($totalPrice,$totalCount);
        if($is_free){
            $freight = 0;
        }else{
            $address = $this->getUserAddress();
            $freightService = new Freight();
            $freightService->setAddress($address);
            $freightService->setProducts($this->oProducts,$this->products);
            $freight = $freightService->calculateFreight();
        }
        return $freight;
    }

    public function isFreightFree($totalPrice,$totalCount){
        $is_free = false;
        $priceItmes = model('ShippingRuleItem')->with('rule')->where('unit',0)
            ->order('number desc')->select()->toArray();
        $countItmes = model('ShippingRuleItem')->with('rule')->where('unit',1)
            ->order('number desc')->select()->toArray();
        if($priceItmes){
            $priceShippingRule = $this->getShippingRuleItem($priceItmes);
            if(!empty($priceShippingRule) && $totalPrice>=$priceShippingRule['number']){
                $is_free = true;
                return $is_free;
            }
        }
        if($countItmes){
            $countShippingRule = $this->getShippingRuleItem($countItmes);
            if(!empty($countShippingRule) && $totalCount>=$countShippingRule['number']){
                $is_free = true;
                return $is_free;
            }
        }
        return $is_free;
    }

    public function getShippingRuleItem($ruleItems){
        $shippingRule = [];
        $address = $this->getUserAddress();
        $areaNames = [
            $address['province'],
            $address['city'],
            $address['country']
        ];
        $areaIds = model('Region')->where('name','in',$areaNames)->column('id');
        $areaIdStr = implode(',',$areaIds);
        foreach ($ruleItems as &$ruleItem){
            if((strpos($ruleItem['exc_region'],$areaIdStr)>=0) || ($ruleItem['rule']['is_long_term']==0 && (time()<$ruleItem['rule']['start_time'] || time()>$ruleItem['rule']['end_time']))){
                unset($ruleItem);
            }
        }
        $productStr = implode(',',array_column($this->oProducts,'product_id'));
        if($ruleItems){
            foreach ($ruleItems as $ruleItem){
                if($ruleItem['rule']['product_ids'] == 0 or strpos($ruleItem['rule']['product_ids'],$productStr)>=0){
                    unset($ruleItem['rule']);
                    $shippingRule = $ruleItem;
                    break;
                }
            }
        }
        return $shippingRule;
    }
    // 根据订单查找真实商品
    private function getProductsByOrder($oProducts)
    {
        $oPIDs = [];
        foreach ($oProducts as $item) {
            array_push($oPIDs, $item['product_id']);
        }
        // 为了避免循环查询数据库
        $products = Product::all($oPIDs);
        return $products;
    }

    private function getUserAddress()
    {
        $address = [];
        $userAddress = UserAddress::where('user_id', '=', $this->uid)->find();
        if($userAddress){
            $address = $userAddress->hidden(['update_time'])->toArray();
        }
        return $address;

    }

    private function getDefaultIdentifyCardId(){
        $identifyCardId = 0;
        if(isset($this->pOrder['identify_card_id']) && $this->pOrder['identify_card_id']){
            $identifyCardId = $this->pOrder['identify_card_id'];
        }
        return $identifyCardId;
    }
    // 创建订单时没有预扣除库存量，简化处理
    // 如果预扣除了库存量需要队列支持，且需要使用锁机制
    private function createOrderByTrans($snap)
    {
        try {
            $orderNo = self::makeOrderNo();
            $order = new OrderModel();
            $order->user_id = $this->uid;
            $order->identify_card_id = $this->getDefaultIdentifyCardId();
            $order->order_no = $orderNo;
            $order->product_price = $snap['productPrice'];
            $order->total_price = $snap['totalPrice'];
            $order->shipping_price = $snap['shippingPrice'];
            $order->order_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->delivery_time = isset($this->pOrder['delivery_time'])?$this->pOrder['delivery_time']:1;
            $order->invoice_title = isset($this->pOrder['invoice_title'])?$this->pOrder['invoice_title']:'';
            $order->taxpayer = isset($this->pOrder['taxpayer'])?$this->pOrder['taxpayer']:'';
            $order->remark = isset($this->pOrder['remark'])?$this->pOrder['remark']:'';
            $order->snap_address = json_encode($this->getUserAddress());
            $order->save();
            $orderID = $order->id;
            $create_time = $order->create_time;
            $orderProducts = $this->getOrderProducts($orderID);
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($orderProducts);
            return [
                'order_no' => $orderNo,
                'order_id' => $orderID,
                'create_time' => $create_time
            ];
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage(),$ex->getCode());
        }
    }

    private function reduceStock()
    {
        foreach ($this->oProducts as $oProduct) {
            model('Product')->where('id',$oProduct['product_id'])->dec('stock',$oProduct['count'])->inc('sales_volume')->update();
        }
    }

    public function getOrderIsAllowReturn($status,$confirmTime,$orderId){
        $flag = false;
        $count = model('OrderProduct')->where('order_id',$orderId)->where('is_return',0)->count();
        if($count>0 && $status == OrderStatusEnum::RECEIVE && (time()-$confirmTime)<config('return.apply_after_service_time')){
            $flag = true;
        }
        return $flag;
    }
    private function getOrderProducts($orderId){
        $orderProducts = [];
        for($i=0;$i<count($this->oProducts);$i++){
            $product = $this->products[$i];
            $oProduct = $this->oProducts[$i];
            $orderProduct['user_id'] = $this->uid;
            $orderProduct['order_id'] = $orderId;
            $orderProduct['product_id'] = $product['id'];
            $orderProduct['product_sn'] = $product['product_sn'];
            $orderProduct['name'] = $product['name'];
            $orderProduct['thumb_img'] = $product['thumb_img'];
            $orderProduct['original_price'] = $product['original_price'];
            $orderProduct['price'] = $product['price'];
            $orderProduct['total_price'] = $product['price'] * $oProduct['count'];
            $orderProduct['count'] = $oProduct['count'];
            $orderProduct['nation'] = $product['nation'];
            array_push($orderProducts,$orderProduct);
        }
        return $orderProducts;
    }

    private function getSnapName(){
        $snapName = $this->products[0]['name'];
        if (count($this->products) > 1) {
            $snapName .= '等';
        }
        return $snapName;
    }

    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }

    public function refund($order){
        $total_fee = $order['total_fee'];
        $refund_fee = $order['order_price']*100;
        $refundParame = [
            'transaction_id' => $order['transaction_id'],
            'out_refund_no' => md5(uniqid()),
            'total_fee' => $total_fee,
            'refund_fee' => $refund_fee
        ];
        $result = Refund::refund($refundParame);
        return $result;
    }
}