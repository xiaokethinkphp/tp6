<?php

namespace app\api\controller\v2;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     * @param int $id
     * @return string
     * @throws \think\Exception
     */
    public function getBanner($id)
    {
        return 'This is V2 version';
    }
}