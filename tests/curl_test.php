<?php
function getAvailableDomain($strName, $intMaxDepth)
{
    echo "testing:$strName ... \n";
    if (strlen($strName) === $intMaxDepth) {
        if ($strName < 'xls') {
            return;
        }
        $url = "http://pandavip.www.net.cn/check/check_ac1.cgi?domain=$strName.com";
        $objCurl = curl_init();

        curl_setopt($objCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($objCurl, CURLOPT_URL, $url);
        curl_setopt($objCurl, CURLOPT_TIMEOUT, 5);

        $res = curl_exec($objCurl);
        if (preg_match('#is available#', $res) > 0) {
            echo "available!\n";
        }
        curl_close($objCurl);

        return;
    }

    $c = 'a';
    for ($i = 0; $i < 26; $i++) {
        getAvailableDomain($strName.$c, $intMaxDepth);
        ++$c;
    }
}

getAvailableDomain('', 3);
