<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/30 0030
 * Time: 下午 3:36
 */

namespace app\admin\validate;

class Tags extends BaseValidate
{
    protected $rule = [
      'title|标签名称' => 'require|max:50|isNotEmpty',
    ];

}