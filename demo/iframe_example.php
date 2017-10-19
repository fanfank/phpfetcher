<?php

use Phpfetcher\Crawler\DefaultCrawler;

require __DIR__.'/../vendor/autoload.php';

class mycrawler extends DefaultCrawler
{
    public function handlePage($page)
    {
        echo "+++ enter page: [".$page->getUrl()."] +++\n";

        //选取所有包含src属性的iframe元素
        $arrIframes = $page->sel('//iframe[@src]');
        for ($i = 0; $i < count($arrIframes); ++$i) {
            $strSrc = $arrIframes[$i]->src;
            echo "found iframe url=[".$strSrc."]\n";
            $this->addAdditionalUrls($strSrc);
        }
        echo "--- leave page: [".$page->getUrl()."] ---\n";
    }

}

;

$crawler = new mycrawler();
$arrJobs = [
    '163' => [
        'start_page' => 'http://news.163.com',
        'link_rules' => [],
        'max_depth'  => 2,
    ],
];

$crawler->setFetchJobs($arrJobs)->run();

echo "Done!\n";
