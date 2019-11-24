<?php


namespace app\api\exception;


use app\lib\exception\BaseException;

class CategoryException extends BaseException
{
    public $code = 404;
    public $errorCode = 50000;
    public $msg = '指定类目不存在，请检查参数';
    /**
     * CategoryException constructor.
     */
    public function __construct()
    {
    }
}