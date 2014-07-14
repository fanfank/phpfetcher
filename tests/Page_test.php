<?php
require_once('autoload.php');
$page = new Phpfetcher_Page_Default();
$page->init();
$page->setConf('url', 'http://news.qq.com/a/20140713/002404.htm');
$page->read();
//echo $page->getContent();
//
$DOMElement_id_oneKey = $page->selId('oneKey');
var_dump($DOMElement_id_oneKey);
echo "\n";
var_dump($DOMElement_id_oneKey->parentNode);
echo "\n";
var_dump($DOMElement_id_oneKey->childNodes);
//echo $DOMElement_id_oneKey->nodeValue;



?>
