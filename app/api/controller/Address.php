<?php


namespace app\api\controller;


use app\api\model\User as UserModel;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address
{
    public function createOrUpdateAddress()
    {
        (new AddressNew())->goCheck();
        // 根据Token获取uid
        // 根据uid查找用户数据，判断用户是否存在，如果不存在则抛出异常
        // 获取客户端提交过来的地址信息
        // 根据用户地址信息是否存在，从而判断是添加地址还是更新地址
        $uid = TokenService::getCurrentTokenVar();
        $user = UserModel::find($uid);
        if (!$user) {
            throw new UserException();
        }

        $userAddress = $user->address;
        if (!$userAddress) {
            $user->address()->save();
        } else {
            $user->address->save();
        }
        return new SuccessMessage();
    }
}