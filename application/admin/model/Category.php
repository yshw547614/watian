<?php
/**
 * Created by PhpStorm.
 * User: shengwang.yang
 * Date: 2018/5/2 0002
 * Time: 上午 11:14
 */

namespace app\admin\model;

use app\common\service\Images;

class Category extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['update_time','delete_time'];

    protected static function init()
    {
        /**
         * 模型事件，在删除事件前执行该方法删除当前商品类目缩略图片
         */
        self::event('before_delete',function ($category){
            $image = new Images();
            $imgUploadPath = config('product.images_upload_path');
            $topicImg = $imgUploadPath.$category->getData('topic_img');
            $image->deleteImg($topicImg);
        });
    }

}