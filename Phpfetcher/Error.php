<?php
class Phpfetcher_Error {
    //error codes
    const ERR_SUCCESS = 0;

    const ERR_INVALID_FIELD = 1000;

    //error messages
    protected static $_arrErrcode2Errmsg = array(
        ERR_SUCCESS       => 'success',    
        ERR_INVALID_FIELD => 'No such field in array',
    );

    public static getErrmsg($errcode) {
        return self::$_arrErrcode2Errmsg[$errcode];
    }
}
?>
