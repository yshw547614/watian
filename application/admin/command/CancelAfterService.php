<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/11 0011
 * Time: 下午 3:40
 */

namespace app\admin\command;
use app\admin\model\AfterService;
use app\admin\model\AfterServiceProduct;
use app\admin\model\OrderProduct;
use app\common\enum\ReturnStatusEnum;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class CancelAfterService  extends Command
{
    protected function configure()
    {
        $this->setName('cancel_after_service')->setDescription('Here is the remark ');
    }
    protected function execute(Input $input, Output $output)
    {
        $this->task();
    }
    private function task(){
        $model = new AfterService();
        $afterServiceProductModel = new AfterServiceProduct();
        $orderProductModel = new OrderProduct();
        $afterServiceData = [
            'status' => ReturnStatusEnum::CANCEL,
            'canceltime' => time()
        ];
        $afterServiceIds = $model->where('status',ReturnStatusEnum::THROUGH)
            ->whereTime('create_time','<','-2 days')->column('id');
        $model->where('id','in',$afterServiceIds)->update($afterServiceData);
        $orderProductIds = $afterServiceProductModel->where('after_service_id','in',$afterServiceIds)
            ->column('order_product_id');
        $orderProductModel->where('id','in',$orderProductIds)->update(['is_return'=>0]);
    }
}