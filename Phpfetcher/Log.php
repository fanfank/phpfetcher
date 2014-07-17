<?php
class Phpfetcher_Log {
    const LOG_LEVEL_DEBUG   = 1;
    const LOG_LEVEL_NOTICE  = 2;
    const LOG_LEVEL_WARNING = 3;
    const LOG_LEVEL_FATAL   = 4;

    public function __construct() {

    }

    static public function warning($strMsg) {
        $strMsg = strval($strMsg);
        self::_print(self::LOG_LEVEL_WARNING, $strMsg);
    }

    static protected function _print($log_level, $strMsg) {
        /*
        if ($log_level == self::LOG_LEVEL_WARNING) {
            $strMsg = 'Warning: ' . $strMsg . "\n";
            echo $strMsg;
        }
        */
        switch($log_level) {
            case self::LOG_LEVEL_FATAL:
                break;
            case self::LOG_LEVEL_WARNING:
                $strMsg = 'Warning: ' . $strMsg . "\n";
                echo $strMsg;
                break;
            case self::LOG_LEVEL_NOTICE:
                break;
            case self::LOG_LEVEL_DEBUG:
                break;
        }
    }
}
?>
