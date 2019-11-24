<?php


namespace app\api\model;


class BannerItem extends BaseModel
{
    protected $hidden = ['id','img_id','banner_id','update_time','delete_time'];

    public function banner()
    {
        return $this->belongsTo('Banner','banner_id','id');
    }

    public function image()
    {
        return $this->hasMany('Image','from','id');
    }
}