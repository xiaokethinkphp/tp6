<?php

namespace app\api\model;

class Banner extends BaseModel
{

    protected $hidden = ['update_time','delete_time'];
    public static function getBannerByID($id)
    {

        $banner = self::with(['items','items.image'])->find($id);
//        $banner = self::with(['items','items.image'])->select();
        return $banner;
        // TODO::
    }

    public function items()
    {
        return $this->hasMany('BannerItem','banner_id','id');
    }
}