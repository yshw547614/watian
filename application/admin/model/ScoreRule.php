<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/27 0027
 * Time: 上午 10:45
 */

namespace app\admin\model;

use app\admin\model\BaseModel;

class ScoreRule extends Rule
{
    public function checkData($data){
        validate('ScoreRule')->checkData($data);
    }
}