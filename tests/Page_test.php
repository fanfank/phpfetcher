<?php
//require_once('autoload.php');
require_once('phpfetcher.php');
$page = new Phpfetcher_Page_Default();
$page->init();
//$page->setConfField('url', 'http://tech.qq.com/a/20140715/073002.htm');
$page->setConfField('url', 'http://news.qq.com/a/20140921/000030.htm');
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
//$res = $page->xpath('a');
var_dump($res->item(0)->nodeValue);
//var_dump($res->item(1)->nodeValue);
/*
$arrLinks = array();
$res = $page->xpath('//a/@href');
for($i = 0; $i < $res->length;++$i) {
    //var_dump($res->item($i));
    $arrLinks[] = $res->item($i)->nodeValue;
}
 */
//$arrLinks = $page->getHyperLinks();
//print_r($arrLinks);



?>
