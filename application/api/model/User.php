<?php

namespace app\api\model;

use think\Model;

class User extends Model
{
    protected $autoWriteTimestamp = true;

    public function orders()
    {
        return $this->hasMany('Order', 'user_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public function addons(){
        return $this->hasOne('UserAddons','user_id','id');
    }

    public function album(){
        return $this->hasMany('UserAlbum','user_id','id');
    }
    public function getImgAttr($value){
        return config('domain').config('user.images_web_path').$value;
    }

    public function getHeadImgAttr($value){
        $image = Images::get($value);
        return $image['url'];
    }
    /**
     * 用户是否存在
     * 存在返回uid，不存在返回0
     */
    public static function getByOpenID($openid)
    {
        $user = self::where('openid', '=', $openid)->find();
        return $user;
    }

    public static function getUserByPage($page,$size){
        $userList = self::with('addons')->order('create_time desc')->paginate($size,true,['page'=>$page]);
        return $userList;
    }


}
