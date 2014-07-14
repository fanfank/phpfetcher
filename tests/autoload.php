<?php
define('LIBS_PATH', '../');
function __autoload($strClassName) {
    require_once LIBS_PATH . str_replace('_', '/', $strClassName) . '.php';
}
spl_autoload_register('__autoload');
?>
