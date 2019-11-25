<?php


namespace app\api\controller;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{

    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        $token = $ut->get();
        return json([
            'token' =>  $token
        ]);
    }
}