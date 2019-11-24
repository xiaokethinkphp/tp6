<?php
/**
 * Created by PhpStorm.
 * User: xiaoke
 * Date: 11/24/19
 * Time: 3:49 PM
 */

namespace app\api\service;


class Token
{
    public static function generateToken()
    {
        // 32charactors
        $ranfChars = getRandChars(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($ranfChars.$timestamp.$salt);
    }
}