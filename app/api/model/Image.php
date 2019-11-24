<?php


namespace app\api\model;


class Image extends BaseModel
{
    protected $hidden = ['delete_time', 'id', 'from'];

    public function bannerItems()
    {
        return $this->belongsTo('BannerItems','from','id');
    }

    public function getUrlAttr($value,$data)
    {
        return $this->prefixImgUrl($value,$data);
    }


}