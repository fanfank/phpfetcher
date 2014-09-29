<?php
class Phpfetcher_Log {
    const LOG_LEVEL_DEBUG   = 1;
    const LOG_LEVEL_NOTICE  = 2;
    const LOG_LEVEL_WARNING = 3;
    const LOG_LEVEL_FATAL   = 4;

    public function __construct() {

    }

    static public function debug($strMsg, $intTraceLevel = 0) {
        $strMsg = strval($strMsg);
        self::_print(self::LOG_LEVEL_DEBUG, $strMsg, $intTraceLevel);
    }

    static public function notice($strMsg, $intTraceLevel = 0) {
        $strMsg = strval($strMsg);
        self::_print(self::LOG_LEVEL_NOTICE, $strMsg, $intTraceLevel);
    }

    static public function warning($strMsg, $intTraceLevel = 0) {
        $strMsg = strval($strMsg);
        self::_print(self::LOG_LEVEL_WARNING, $strMsg, $intTraceLevel);
    }


    static public function fatal($strMsg, $intTraceLevel = 0) {
        $strMsg = strval($strMsg);
        self::_print(self::LOG_LEVEL_FATAL, $strMsg, $intTraceLevel);
    }

    static protected function _print($log_level, $strMsg, $intTraceLevel = 0) {
        switch($log_level) {
            case self::LOG_LEVEL_FATAL:
                $strPrepend = 'Fatal: ';
                $strAppend = "\n";
                break;
            case self::LOG_LEVEL_WARNING:
                $strPrepend = 'Warning: ';
                $strAppend = "\n";
                break;
            case self::LOG_LEVEL_NOTICE:
                $strPrepend = 'Notice: ';
                $strAppend = "\n";
                break;
            case self::LOG_LEVEL_DEBUG:
                $strPrepend = 'Debug: ';
                $strAppend = "\n";
                break;
        }

        //参考了其它地方的代码
        $arrTrace = debug_backtrace();
        $intDepth = 2 + $intTraceLevel;
        $intTraceDepth = count($arrTrace);
        if ($intDepth > $intTraceDepth) {
            $intDepth = $intTraceDepth;
        }
        $arrTargetTrace = $arrTrace[$intDepth];
        unset($arrTrace);
        if (isset($arrTargetTrace['file'])) {
            $arrTargetTrace['file'] = basename($arrTargetTrace['file']);
        }

        $strPrepend = strval(@date("Y-m-d H:i:s")) . " {$arrTargetTrace['file']} {$arrTargetTrace['class']} {$arrTargetTrace['function']} {$arrTargetTrace['line']} " . $strPrepend . ' ';

        $strMsg = $strPrepend . $strMsg . $strAppend;

        echo $strMsg;
    }
}
?>
