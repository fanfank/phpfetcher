<?php
$demo_include_path = dirname(__FILE__) . '/../';
set_include_path(get_include_path() . PATH_SEPARATOR . $demo_include_path);

require_once('phpfetcher.php');
class mycrawler extends Phpfetcher_Crawler_Default {
    public function handlePage($page) {
        //echo "Current Url: [" . $page->getUrl() . "]\n";

        ////$arrScripts = $page->sel('//iframe');
        ////echo count($arrScripts) . "\n";

        ////选取所有包含src属性的iframe元素
        //$arrIframes = $page->sel('//iframe[@src]'); 
        //for ($i = 0; $i < count($arrIframes); ++$i) {
        //    //echo print_r(get_class($arrIframes[$i]), true) . "\n";
        //    $strSrc = $arrIframes[$i]->src; //some problem
        //    echo "add iframe src=[" . $strSrc . "] to next depth\n";
        //    //$this->addAdditionalUrls($strSrc);
        //    break;
        //}
        //echo "Finish Url: [" . $page->getUrl() . "]\n";
    }

};

$crawler = new mycrawler();
$arrJobs = array(
    '163' => array( 
        'start_page' => 'http://news.163.com',
        'link_rules' => array(),
        'max_depth' => 2, 
    ) ,   
);
print_r(get_class_methods(mycrawler));
die(0);

$crawler->addAdditionalUrls('http://news.qq.com');

$crawler->setFetchJobs($arrJobs)->run();
