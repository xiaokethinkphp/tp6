<?php


namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids'   =>  ['require','checkIDs']
    ];

    protected $message = [
        'ids'   =>  'ids参数必须是以逗号分隔的多个正整数'
    ];

}