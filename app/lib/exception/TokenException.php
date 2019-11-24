<?php
/**
 * Created by PhpStorm.
 * User: xiaoke
 * Date: 11/24/19
 * Time: 4:11 PM
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或无效';
    public $errorCode = 10001;
}