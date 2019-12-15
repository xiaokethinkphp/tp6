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
    /**
     * 生成令牌
     * @return string
     */
    public static function generateToken()
    {
        // 32characters
        $randChars = getRandChars(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

    /**
     * 根据key值获取Token变量值
     * @param $key
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
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

    /**
     * 从Token中获取当前用户的uid
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getCurrentUid()
    {
        // token
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /**
     * 检测是否是当前用户
     * @param $checkedUID
     * @return bool
     * @throws Exception
     * @throws TokenException
     */
    public static function isValidOperate($checkedUID)
    {
        if (!$checkedUID) {
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }

        $currentOperateUID  = self::getCurrentUid();
        if ($currentOperateUID == $checkedUID) {
            return true;
        }
        return false;
    }
}