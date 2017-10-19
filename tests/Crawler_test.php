<?php
require_once('bootstrap.php');

use Phpfetcher\Crawler\DefaultCrawler;

class mycrawler extends DefaultCrawler
{
    public function handlePage($page)
    {
        print_r($page->getHyperLinks());
    }
}

$crawler = new mycrawler();
$arrFetchJobs = [
    'blog.reetsee' => [
        'start_page' => 'http://blog.reetsee.com',
        'link_rules' => [
            '/blog\.reetsee\.com/',
            '/wordpress/',
        ],
    ],
    'qq'           => [
        'start_page' => 'http://news.qq.com',
        'link_rules' => [
            '/(.*)\/a\/(\d{8})\/(\d+)\.htm/',
        ],
        'max_depth'  => 4,
    ],
];
$crawler->setFetchJobs($arrFetchJobs)->run();
//$page->setConfField('url', 'http://tech.qq.com/a/20140715/073002.htm');
