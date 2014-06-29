<?php
$objCurl = curl_init('http://news.qq.com/a/20140623/002818.htm');

curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, 0);

echo curl_exec($objCurl);

curl_close($objCurl);
?>
