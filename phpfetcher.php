<?php
define('PHPFETCHER_PATH', dirname(__FILE__));
function __autoload($strClassName) {
    if (substr($strClassName, 0, count('Phpfetcher_')) === 'Phpfetcher_') {
        require_once PHPFETCHER . str_replace('_', '/', $strClassName) . '.php';
    }
}
spl_autoload_register('__autoload');
?>
