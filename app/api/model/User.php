<?php


namespace app\api\model;


class User extends BaseModel
{
    public static function getByOpenID($openid)
    {
        $user = self::where('openod','=',$openid)->find();
        return $user;
    }
}