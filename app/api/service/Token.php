<?php
/**
 * Created by PhpStorm.
 * User: xiaoke
 * Date: 11/24/19
 * Time: 3:49 PM
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\facade\Cache;
use think\Exception;

class Token
{
    public static function generateToken()
    {
        // 32charactors
        $randChars = getRandChars(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = \think\facade\Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            $vars = json_decode($vars,true);
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    public static function getCurrentUid()
    {
        // token
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }
}