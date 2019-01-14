<?php

namespace app\api\model;

use app\common\model\Advert as CommenAdvert;

class Advert extends BaseModel
{
    use CommenAdvert;
    /**
     * @param $id int banner所在位置
     * @return Banner
     */
    public static function getAdvertById($id)
    {
        $banner = self::get($id,'items');
        return $banner;
    }
}
