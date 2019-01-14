<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/2 0002
 * Time: 下午 2:23
 */

namespace app\admin\validate;

class Category extends BaseValidate
{
    protected $rule = [
        'name|分类标题' => 'require|max:100',
        'is_home|首页展示' => 'in:0,1',
        'is_vouch|是否推荐' => 'in:0,1',
        'advert_id|页面广告' => 'isInteger',
        'pid' => 'require|isInteger|checkPid'
    ];

    public function checkPid($value){
        if($value == 0){
            return true;
        }else{
            $category = model('Category')->where('id',$value)->find();
            if(!$category){
                return '上级类目错误';
            }
            $parent = model('Category')->where('id',$category['pid'])->find();
            if($parent){
                return '商品类目暂时只支持二级类目';
            }
            return true;
        }
    }
}