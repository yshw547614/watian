<?php

namespace app\api\model;

use app\common\model\AdvertItem as CommenAdvertItem;

class AdvertItem extends BaseModel
{
    protected $hidden = ['id', 'advert_id'];
    use CommenAdvertItem;
}
