<?php
namespace app\lib\exception;

use think\facade\Env;
use think\Exception;
use think\exception\Handle;
use think\facade\Log;
use think\Response;
use Throwable;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    // 需要返回客户端当前请求的URL路径
    public function render($request, Throwable $e): Response
    {
        if ($e instanceof BaseException) {
            // 如果是自定义的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            //  设置异常开关

            if (Env::get("APP_DEBUG")) {
                // 还原TP自己的render处理
                return parent::render($request, $e);
            } else {
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorCode = 999;
                $this->recordErrorLog($e);
            }
        }

        $result = [
            'msg'   =>  $this->msg,
            'error_code'    =>  $this->errorCode,
            'request_url'   =>  $request->url()
        ];
        return json($result,$this->code);
//        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }

    private function recordErrorLog($e)
    {
        Log::init([
           'type'   =>  'File',
//           'path'   =>  LOG_PATH,
           'level'  =>  ['error']
        ]);
        Log::record($e->getMessage(),'error');
    }

}