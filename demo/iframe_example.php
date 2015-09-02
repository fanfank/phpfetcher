<?php
$demo_include_path = dirname(__FILE__) . '/../';
set_include_path(get_include_path() . PATH_SEPARATOR . $demo_include_path);

require_once('phpfetcher.php');
class mycrawler extends Phpfetcher_Crawler_Default {
    public function handlePage($page) {
        echo "Current Url: [" . $page->getUrl() . "]\n";

        //选取所有包含src属性的iframe元素
        $arrIframes = $page->sel('//iframe[@src]'); 
        for ($i = 0; $i < count($arrIframes); ++$i) {
            $strSrc = $arrIframes[$i]->src; //some problem
            echo "add iframe src=[" . $strSrc . "] to next depth\n";
            $this->addAdditionalUrls($strSrc);
        }
        echo "Finish Url: [" . $page->getUrl() . "]\n";
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

$crawler->setFetchJobs($arrJobs)->run();

echo "Done!\n";
