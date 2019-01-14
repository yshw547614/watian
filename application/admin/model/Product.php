<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/2 0002
 * Time: 上午 11:14
 */

namespace app\admin\model;

use app\common\model\Product as ProductCommon;
use think\Cache;
use app\common\service\Images as ImagesService;

class Product extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['delete_time'];

    use ProductCommon;

    public function getUpperShelfTimeAttr($value){
        if($value){
            return date('Y-m-d H:i:s',$value);
        }
    }

}