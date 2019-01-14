<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/27 0027
 * Time: 下午 2:16
 */

namespace app\admin\validate;

class ScoreRule extends BaseValidate
{
    protected $rule = [
        'title|标题' => 'require|isNotEmpty|max:100',
        'score|分数' =>'require|isPositiveInteger',
        'day_limit|每日限制次数' =>'require|isInteger',
    ];
}