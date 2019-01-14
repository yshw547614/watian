<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/6/5 0005
 * Time: 下午 4:01
 */

namespace app\admin\validate;


class Advert extends BaseValidate
{
  protected $rule = [
    'name' => 'require|isNotEmpty',
  ];
}