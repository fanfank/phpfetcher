<?php
require_once('simple_html_dom.php');
$str = 'http://news.sina.com.cn/s/2014-09-27/150630924264.shtml';
$html = file_get_html($str);
//var_dump($html);
//var_dump($html->find('//h1', 0)->plaintext);
$res = $html->find('//p');
for($i = 0; $i < count($res); ++$i) {
    $arrContent = 
}
for($i = 0; $i < $res->length; ++$i) {

}
