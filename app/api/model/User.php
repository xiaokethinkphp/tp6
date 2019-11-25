<?php


namespace app\api\model;


class User extends BaseModel
{
    public static function getByOpenID($openid)
    {
        $user = User::where('openid','=',$openid)->find();
        return $user;
    }
}