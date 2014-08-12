<?php
require_once('autoload.php');
class mycrawler extends Phpfetcher_Crawler_Default {
    public function handlePage($page) {
        print_r($page->getHyperLinks());
    }
}

$crawler = new mycrawler();
$arrFetchJobs = array(
    'blog.reetsee' => array(
        'start_page' => 'http://blog.reetsee.com', 
        'link_rules' => array(
            '/blog\.reetsee\.com/',   
            '/wordpress/',
        ),
    ),        
    'qq' => array(
        'start_page' => 'http://news.qq.com',   
        'link_rules' => array(
            '/(.*)\/a\/(\d{8})\/(\d+)\.htm/',    
        ),
        'max_depth' => 4, 
    ),
);
$crawler->setFetchJobs($arrFetchJobs)->run();
//$page->setConfField('url', 'http://tech.qq.com/a/20140715/073002.htm');

?>
