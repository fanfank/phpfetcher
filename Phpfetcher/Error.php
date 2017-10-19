<?php

namespace Phpfetcher;

/**
 * @author xuruiqi
 * @date   20150406
 * @copyright reetsee.com
 */

class Error
{
    //error codes
    const ERR_SUCCESS = 0;
    const ERR_INVALID_FIELD = 1000;
    const ERR_FIELD_NOT_SET = 1001;

    //error messages
    protected static $_arrErrcode2Errmsg = [
        self::ERR_SUCCESS       => 'Success',
        self::ERR_INVALID_FIELD => 'Invalid field in array',
        self::ERR_FIELD_NOT_SET => 'Accessing a non-set field',
    ];

    public static function getErrmsg($errcode)
    {
        return self::$_arrErrcode2Errmsg[$errcode]."\n";
    }
}
