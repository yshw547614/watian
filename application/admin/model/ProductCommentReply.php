<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/7/20 0020
 * Time: 下午 4:05
 */

namespace app\admin\model;


use think\Model;

class ProductCommentReply extends Model
{
    protected $hidden = ['id','product_comment_id'];
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

}