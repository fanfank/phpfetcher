<?php
define('PHPFETCHER_PATH', dirname(__FILE__));
function __autoload($strClassName) {
    if (substr($strClassName, 0, strlen('Phpfetcher_')) === 'Phpfetcher_') {
        require_once PHPFETCHER_PATH . str_replace('_', '/', $strClassName) . '.php';
    }
}
spl_autoload_register('__autoload');
?>
