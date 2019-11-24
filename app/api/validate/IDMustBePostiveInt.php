<?php

namespace app\api\validate;

class IDMustBePostiveInt extends  BaseValidate
{
    protected $rule = [
        'id'    =>  ['require','isPositiveInteger'],
        'num'   =>  ['in:1,2,3']
    ];


}