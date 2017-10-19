<?php

use Phpfetcher\Crawler\DefaultCrawler;

require __DIR__.'/../vendor/autoload.php';

class mycrawler extends DefaultCrawler
{
    public function handlePage($page)
    {
        //打印处当前页面的title
        $res = $page->sel('//title');
        for ($i = 0; $i < count($res); ++$i) {
            echo $res[$i]->plaintext;
            echo "\n";
        }
    }
}

$crawler = new mycrawler();
$arrJobs = [
    //任务的名字随便起，这里把名字叫qqnews
    //the key is the name of a job, here names it qqnews
    'qqnews' => [
        'start_page' => 'http://jianli.58.com/resume/93489192884492', //起始网页
        'link_rules' => [
            /*
             * 所有在这里列出的正则规则，只要能匹配到超链接，那么那条爬虫就会爬到那条超链接
             * Regex rules are listed here, the crawler will follow any hyperlinks once the regex matches
             */
        ],
        //爬虫从开始页面算起，最多爬取的深度，设置为1表示只爬取起始页面
        //Crawler's max following depth, 1 stands for only crawl the start page
        'max_depth'  => 1,

        //某些页面做了防抓取策略，可以通过修改UA，或者添加必要的HTTP Header来防止屏蔽
        //Some pages may prevent crawlers from working, you may change UA or add
        //  necessary HTTP Headers to prevent this.
        'page_conf'  => [
            'http_header' => [
                //如果本例子对于你来说运行不成功（发生了错误），那么请将下面的Header
                //  替换成与你浏览器请求Header一样的内容，但是不要添加Accept-Encoding
                //  这个Header
                //If this example can not run successfully, please replace the Headers
                //  below with the ones exactly you see from your browser. Remember
                //  not to add Accept-Encoding header.
                'Host: jianli.m.58.com',
                'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:24.0) Gecko/20100101 Firefox/24.0',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Cookie: 58home=tj; id58=c5/ns1enV2k5MFGqLUAXAg==; city=tj; 58tj_uuid=1cf71e54-dd15-4922-8228-b6bb809edbfd; new_session=0; new_uv=1; utm_source=; spm=; init_refer=; myfeet_tooltip=end; als=0; Hm_lvt_2557cda77f2e9a8b94531c9501582142=1470585797; Hm_lpvt_2557cda77f2e9a8b94531c9501582142=1470585797; 4drh9g=test insert val',
                'Connection: keep-alive',
                'Cache-Control: max-age=0',

                //不要添加Accept-Encoding的Header
                //Do not add Accept-Encoding Header
                //'Accept-Encoding: gzip, deflate' 
            ],
        ],
    ],
];

$crawler->setFetchJobs($arrJobs);
$crawler->run();
