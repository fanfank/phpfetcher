<?php
class Phpfetcher_Error {
    //error codes
    const ERR_SUCCESS = 0;
    const ERR_INVALID_FIELD = 1000;
    const ERR_FIELD_NOT_SET = 1001;

    //error messages
    protected static $_arrErrcode2Errmsg = array(
        ERR_SUCCESS       => 'Success',    
        ERR_INVALID_FIELD => 'Invalid field in array',
        ERR_FIELD_NOT_SET => 'Accessing a non-set field',
    );

    public static getErrmsg($errcode) {
        return self::$_arrErrcode2Errmsg[$errcode];
    }
}
?>
