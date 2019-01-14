<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/9/11 0011
 * Time: 下午 3:40
 */

namespace app\admin\command;

use app\admin\model\Order;
use app\common\enum\OrderStatusEnum;
use think\console\Command;
use think\console\Input;
use think\console\Output;


class CancelOrder  extends Command
{
    protected function configure()
    {
        $this->setName('cancel_order')->setDescription('Here is the remark ');
    }
    protected function execute(Input $input, Output $output)
    {
        $this->task();
    }
    private function task(){
        $model = new Order();
        $data = [
            'status' => OrderStatusEnum::CANCEL,
        ];
        $model->where('status',OrderStatusEnum::UNPAID)->whereTime('create_time','<','-2 hours')->update($data);
    }
}