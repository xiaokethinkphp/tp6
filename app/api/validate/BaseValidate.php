<?php


namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\facade\Request;
use think\Validate;

class BaseValidate extends  Validate
{
    public function goCheck()
    {
        // 获取http传递的参数
        // 对参数进行校验
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if (!$result) {
            $e = new ParameterException([
                'msg'   =>  $this->error,
            ]);
            throw $e;
//            $error = $this->error;
//            throw new BaseException($error);
        } else {
            return true;
        }
    }


    protected function isPositiveInteger($value, $rule='', $data='', $filed='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value+0)>0) {
            return true;
        }
        return false;
    }

    protected function checkIDs($value)
    {
        $values = explode(',', $value);
        if (empty($values)) {
            return false;
        }

        foreach ($values as $id) {
            if (!$this->isPositiveInteger($id)) {
                return false;
            }
        }
        return true;
    }

    protected function isNotEmpty($value, $rule='', $data='', $filed='')
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }

    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id',$arrays)|
            array_key_exists('uid',$arrays)) {
            throw new ParameterException([
                'msg'   =>  '参数中包含有非法的参数名user_id或uid'
            ]);
        }

        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }

        return $newArray;
    }
}