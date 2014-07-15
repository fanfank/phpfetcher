<?php
require_once('autoload.php');
$page = new Phpfetcher_Page_Default();
$page->init();
$page->setConf('url', 'http://tech.qq.com/a/20140715/073002.htm');
$page->read();
//echo $page->getContent();
//$DOMElement_id_oneKey = $page->selId('oneKey');
//var_dump($DOMElement_id_oneKey);
//echo "\n";
//var_dump($DOMElement_id_oneKey->parentNode);
//echo "\n";
//var_dump($DOMElement_id_oneKey->childNodes);
//echo $DOMElement_id_oneKey->nodeValue;
//print_r($page->xpath('//meta[@http-equiv]'));
//var_dump($page->xpath2('//meta[@http-equiv]'));
$res = $page->xpath('//title');
var_dump($res->item(0)->nodeValue);
var_dump($res->item(1)->nodeValue);



?>
