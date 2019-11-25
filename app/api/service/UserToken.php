<?php


namespace app\api\service;


use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;
class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $data = [
            'appid' =>  $this->wxAppID,
            'secret'    =>  $this->wxAppSecret,
            'js_code'   =>  $code,
            'grant_type'    =>  'authorization_code'
        ];
        $this->wxLoginUrl = config('wx.login_url')
            .'?'
            .http_build_query($data);
    }
    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key及open_ID时异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errCode',$wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                return $this->grantToken($wxResult);
            }
        }
    }

    private function processLoginError($wxResult)
    {
        throw new WeChatException([
           'msg' => $wxResult['errmsg'],
            'errorCode' =>  $wxResult['errcode']
        ]);
    }

    // 生成令牌
    private function grantToken($wxResult)
    {
        // 拿到OpenID
        // 数据库里看一下，这个OpenID是不是已经存在
        // 如果存在 则不处理，如果不存在，则新增一条记录
        // 生成令牌，准备缓存数据，写入缓存
        // 把令牌返回到客户端去
        // key:token
        // value:wxResult,uid,scope
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if ($user) {
            $uid = $user->id;
        } else {
            $uid = $this->newUser($openid);
        }
        $cachedValue =$this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    private function saveToCache($cachedValue)
    {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key,$value,$expire_in);
        if (!$request) {
            throw new TokenException([
                'msg'   =>  '',
                'errorCode' =>  10005
            ]);
        }
        return $key;
    }

    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 16;
        return $cachedValue;
    }

    private function newUser($openid)
    {
        $user = UserModel::create([
            'openid'    =>  $openid
        ]);
        return $user->id;
    }
}