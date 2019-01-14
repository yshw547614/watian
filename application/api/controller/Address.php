<?php
/**
 * Date: 2017/2/23
 * Time: 2:56
 */

namespace app\api\controller;

use app\api\model\User;
use app\api\model\UserAddress;
use app\api\service\Token;
use app\api\validate\AddressNew;
use think\Exception;
use app\common\response\RequestResponse;

class Address extends BaseController
{
    /**
     * 获取用户地址信息
     * @return UserAddress
     */
    public function getUserAddress(){
        $uid = Token::getCurrentTokenVar('uid');
        $userAddress = UserAddress::where('user_id', $uid)->find();
        if(!$userAddress)
        {
            throw new Exception('用户地址不存在',502);
        }
        return RequestResponse::getResponse('','','',$userAddress);
    }

    /**
     * 更新或者创建用户收获地址
     */
    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->checkUp();
        $uid = Token::getCurrentTokenVar('uid');
        $user = User::get($uid);
        if(!$user){
            return RequestResponse::getResponse('用户收获地址不存在','error',404);
        }
        $userAddress = $user->address;
        // 根据规则取字段是很有必要的，防止恶意更新非客户端字段
        $data = $validate->getDataByRule(input('post.'));

        if (!$userAddress )
        {
            // 关联属性不存在，则新建
            $user->address()->save($data);
        }
        else{
            // 存在则更新
            // fromArrayToModel($user->address, $data);
            // 新增的save方法和更新的save方法并不一样
            // 新增的save来自于关联关系
            // 更新的save来自于模型
            $user->address->save($data);
        }
        return RequestResponse::getResponse();
    }
}