<?php

namespace app\api\controller\v1;

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
    public function getBanner($id=1)
    {
        (new IDMustBePostiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
        if (!$banner) {
            throw new BannerMissException();
        }
//        return json($banner);
        return $banner;
    }
}