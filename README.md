#Phpfetcher    

##中文说明(Scroll Down to See The English Description)    
一个PHP爬虫框架   
框架的起源请参见：http://blog.reetsee.com/archives/366        
注意：PHP 5.4.x可能有BUG以至于有时候执行iframe_example.php出错，如果出现这种情况，请尝试PHP 5.5.x    
###1 例子    
下面的所有例子请在`demo`目录下执行，即假设例子对应的文件名是`hello_world.php`，运行例子时你执行的命令应该是`php hello_world.php`而不是`php demo/hello_world.php`
####1.1 获取页面中`<title>`标签的内容
指定一个新闻页面：`http://news.qq.com/a/20140927/026557.htm`，然后获取网页HTML中的`<title>`标签的内容来获取标题    
请运行`single_page.php`例子，得到的输出如下：    
```
$> php single_page.php 
王思聪回应遭警方调查：带弓箭不犯法 我是绿箭侠_新闻_腾讯网
```    
####1.2 获取腾讯新闻主页的大部分新闻标题    
指定一个种子页面：`http://news.qq.com`，跟踪这个页面的超链接，被跟踪的超链接能被正则表达式`#news\.qq\.com/a/\d+/\d+\.htm$#`匹配，例如`news.qq.com/a/20140927/026557.html`，就会被跟踪。爬虫对于所有爬取的网页（包括起始页`news.qq.com`），抓取所有的`<h1>`标签，并打印内容     
请运行`multi_page.php`，得到的输出如下：    
```
$> php multi_page.php 
  	腾讯新闻——事实派
习近平访英前接受采访 谈及南海问题及足球等
习近平夫妇访英行程确定 将与女王共进私人午宴
李克强：让能干事的地方获得更多支持
环保部：我国40个城市已出现空气质量重污染
京津冀形成两个重污染带 太行燕山东南污染重
铁路部门回应“车票丢失被迫补票”：到站再退款
女大学生火车票遗失被要求补全票 铁路局：没做错
今日话题：丢失火车票要重买，老黄历何时改
外媒：两名藏僧被俄驱逐出境
广西北海民众聚众阻挠海事码头建设 16人被刑拘
河南一村民被政府人员土埋 官方称系邻里纠纷
餐厅用掺老鼠屎黄豆做咸菜 老板：都是中药材
```    
####1.3 获取标签属性值 + 指定额外要跟踪的URL
这个例子用来展现怎么提取HTML标签中的属性以及爬虫运行的过程中如何临时添加需要抓取的URL。我们检查`news.163.com`页面的`<iframe>`标签，并让爬虫进入到iframe标签所指向的URL。
请运行`iframe_example.php`，得到的输出如下：
```
$> php iframe_example.php 
+++ enter page: [http://news.163.com] +++
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=1]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=1]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=2]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=2]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=3]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=4]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x150&location=1]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=5]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=5]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=6]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=7]
--- leave page: [http://news.163.com] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=1] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=1] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=1] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=1] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=2] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=2] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=2] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=2] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=3] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=3] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=4] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=4] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x150&location=1] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x150&location=1] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=5] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=5] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=6] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=6] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=7] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=7] ---
Done!
```     
这和直接在`$arrJobs['link_rules']`指定爬取规则有什么不同呢？不同点如下：     
1. 爬虫默认只爬取`<a>`标签，并将`<a>`标签的`href`属性作为要爬取的地址放入爬取队列中，而地址需要满足的规则就是由`$arrJobs['link_rules']`来决定的。而`<iframe>`标签原本并不是爬虫爬取的目标，并且其地址放在标签的`src`属性中；    
2. 之前的例子中，要爬取的URL都是框架自动添加的，而这个例子中，要爬取的`<iframe>`地址是我们通过调用`$this->addAdditionalUrls($strSrc);`手动添加的。    
####1.4 爬取百度搜索结果
只要你对一个网站的网页结构有一定了解，你就能获取到你想要的所有信息，通过观察百度的搜索结果页，可以发现大多数搜索结果对应的DOM元素有这样的规律：`<h3><a href="我是结果链接地址">我是结果描述文字</a></h3>`，因此我们只要提取`<h3>`标签下的`<a>`标签的文本内容及`href`属性。
请运行`crawl_baidu_page.php`，这个程序会打印关键字`facebook`的搜索结果，得到的输出如下：    
```
$> php crawl_baidu_page.php 
   Facebook 
http://www.baidu.com/link?url=AtASutoPNIKCLMMz_CTeuhoe97gXt5N2JagWcZm0eUO-dvRdInYNWVhk7UVGiSNi

Facebook_百度百科
http://www.baidu.com/link?url=9D5oa_7E1ezSVwfx4hGVRtObcvmruI0UCR_cOTWEnj74p7AiWY_ESYXyvnyVHlXXHOYHh94UaZdiUpnGdS5qQa

facebook - facebook官网_facebook注册
http://www.baidu.com/link?url=3CmiG8W9me4-Xc0WkdDvsLT71hMN37s3o1M11T5VnbN-PFBnCgoCoXJ9-8iIPijf

facebook中文网 - facebook中文官网 facebook网址登陆
http://www.baidu.com/link?url=yJqsEl7U_elBeIsW4i108vaaFNTugzb8nWM8h9kXS0zDdKbBhWEUbcRm7ALY3rQF

facebook吧_百度贴吧
http://www.baidu.com/link?url=mWmpR1_PTCFQuJTmE_TarbSDvvHhhim4w15fQ8dipvJRwLY5twIb17hivcOcUGa-v_mbDS0Bfd4SVh7mjHz4mK

facebook的最新相关信息
http://www.baidu.com/link?url=ARSNH3CTzh9HyGL8VgmREUTI1JC8VNmJ3FPHJn32l_nHFnjKGWdbexnZmsQ7090JoTKVeRVYXlixLaxnjH6yDJt8ln7IJsoihEXPY9B7-m3

Facebook
http://www.baidu.com/link?url=G7GoImtCer71s9xQ0C5rlbCbGN6toa3fONlouj8nlHkIAJg3TrazM4FFw-9sjSzU

Facebook[FB]_美股实时行情_新浪财经
http://www.baidu.com/link?url=AtASutoPNIKCLMMz_CTeuh_n1s-MJ2bubaCG7gsoyh81Oj-9lYKqY4Wv8iYx8OuUhnaOL6R9M8WJTnc5qcrrF8s_vP2R9W0dURAaLW6zT5_

facebook中文网 - facebook官网注册!
http://www.baidu.com/link?url=LDR4I-ZA2VI4YuVk-hLH_SvxNwcynRZJ6qtD1go0wc68Q08viPvLh3-wXvoW3ILS

为什么中国出不了Facebook和Twitter?-月光博客
http://www.baidu.com/link?url=g7e5dKdgTPcIKOwybAPc7mk7omwz94u0xWuZ_9-nS1AGfdotydkziu7vqCRbrVK0T6rTCUSA3Al5mL4Rcl7YY_
```    
###2 获取HTML页面中某个元素的所有信息
可以参考例子1.3以及1.4，实际上主要使用以下四样东西：    
1. xpath，它是用来描述你要查找的HTML标签的语句，可以参考[http://www.w3school.com.cn/xpath/](http://www.w3school.com.cn/xpath/)；    
2. `sel`方法，如所有例子中都有的`$page->sel('xpath语句')`，调用这个方法后会得到一个数组，数组的内容就是所有满足要求的DOM元素的实例；     
3. simplehtmldom的`plaintext`成员，例如例子中的`$res[$i]->plaintext`，保存着DOM元素包裹的文本内容；    
4. simplehtmldom的`getAttribute`方法，例如例子`crawl_baidu_page.php`中的`$res[$i]->getAttribute('href')`，这样你就可以获得对应元素的属性值了。    
基本上熟悉了上面四点，你就能较好地在Phpfetcher中操控DOM元素。
Phpfetcher解析HTML时使用了simplehtmldom这个开源项目的内容，更多关于它的API可以参见[http://simplehtmldom.sourceforge.net/](http://simplehtmldom.sourceforge.net/)，或者[Drupal API的描述](http://api.drupal.psu.edu/api/drupal/modules%21contrib%21simplehtmldom%21simplehtmldom%21simple_html_dom.php/cis7)。
你也可以直接修改本项目中的Phpfetcher/Page/Default.php以及Phpfetcher/Dom/SimpleHtmlDom.php文件，来更好地实现你的需求。
###3 修改user-agent   
之前出现过一个问题就是Phpfetcher由于使用了`phpfetcher`这个user-agent遭到屏蔽。关于什么是user-agent，大家可以搜一下，它可以看成是浏览器对自己的一种标识，例如火狐的UA中会有`Firefox`，Chrome的UA中会有`Chrome`，手机的浏览器中多数会带上`Mobile`字样等，如`Chrome Mobile`、`Safari Mobile`等；
当然UA并不是什么神圣、高深的东西，这个东西随便改。以前百度屏蔽360浏览器的请求时，360浏览器就可以通过修改自己的UA来绕过百度的UA检测（当然百度的屏蔽不止检测UA这一项）
如果大家在使用Phpfetcher过程中，发现有网页返回`Forbidden`等情况，就可以考虑修改一下UA。
直接修改文件`Phpfetcher/Dom/Default.php`中`'user_agent' = 'firefox'`这一行，将`firefox`替换成一个看起来更靠谱的UA。    
```
    protected $_arrDefaultConf = array(
            'connect_timeout' => 10, 
            'max_redirs'      => 10, 
            'return_transfer' => 1,   //need this
            'timeout'         => 15, 
            'url'             => NULL,
            'user_agent'      => 'firefox'
    );
```    
如果替换UA后还是被屏蔽，那就有可能是其它原因了，例如是你的IP被屏蔽了等。
###4 结语
这个框架还有很多不完善的地方，例如怎么使用多线程进行爬取、怎么样模拟登录状态进行爬取等。
但目前框架能适应大多数需求，暂时也比较简单易维护，短期内不会往更复杂的方向发展。
然而设计上的缺陷还是有不少的，例如有没有办法不修改源码去修改UA，去修改CURL的参数等，这些都是可以改进的。不过还是那句，在需求不强烈前，就不去进一步修改现有的结构了。
祝大家用得开心。
##English Description    
A PHP web crawler framework        
The origin of this framework please refer to: http://blog.reetsee.com/archives/366      
NOTE: PHP 5.4.x may have bugs that sometimes iframe_example.php doesn't work, if so, try PHP 5.5.x     
###1 Examples
Please run the following examples under `demo` directory, assume you want to run `hello_world.php`, use `php hellow_world.php` rather than `php demo/hello_world.php`.
####1.1 Get Plaintext of `<title>` Tags
Specify a target page, say `http://news.qq.com/a/20140927/026557.htm`, then get all the plaintext in the `<title>` tags to get the title of the page
Please run the `single_page.php` example, and you will get the following output:    
```
$> php single_page.php 
王思聪回应遭警方调查：带弓箭不犯法 我是绿箭侠_新闻_腾讯网
```     
####1.2 Get Titles of News from The Homepage of Tencent News
Sepcify a seed page, say `http://news.qq.com`, the homepage of tencent news, follow the links of on this page, which satisfy the regrex `#news\.qq\.com/a/\d+/\d+\.htm$#`(e.g. `news.qq.com/a/20140927/026557.html`). The crawlers will inspect `<h1>` tags of all the pages(including the homepage `news.qq.com`), and print the plaintext inside the tags.
Please run `multi_page.php`, and you will get the following output:    
```
$> php multi_page.php 
  	腾讯新闻——事实派
习近平访英前接受采访 谈及南海问题及足球等
习近平夫妇访英行程确定 将与女王共进私人午宴
李克强：让能干事的地方获得更多支持
环保部：我国40个城市已出现空气质量重污染
京津冀形成两个重污染带 太行燕山东南污染重
铁路部门回应“车票丢失被迫补票”：到站再退款
女大学生火车票遗失被要求补全票 铁路局：没做错
今日话题：丢失火车票要重买，老黄历何时改
外媒：两名藏僧被俄驱逐出境
广西北海民众聚众阻挠海事码头建设 16人被刑拘
河南一村民被政府人员土埋 官方称系邻里纠纷
餐厅用掺老鼠屎黄豆做咸菜 老板：都是中药材
```    
####1.3 Get Attributes of HTML Tags + Add Additional Crawling URLs
This example shows how to get attributes of HTML tags, and how to add URLs to be crawled after starting a crawling job. We will ask the crawlers to inspect all the `<iframe>` tags on page `news.163.com`, and make crawlers follow the links where `<iframe>` tags point to.
Please run `iframe_example.php`, and you will get the following output:    
```
$> php iframe_example.php 
+++ enter page: [http://news.163.com] +++
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=1]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=1]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=2]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=2]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=3]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=4]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x150&location=1]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=5]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=5]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=6]
found iframe url=[http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=7]
--- leave page: [http://news.163.com] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=1] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=1] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=1] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=1] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=2] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=2] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=2] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo540x60&location=2] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=3] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=3] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=4] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=4] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x150&location=1] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x150&location=1] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=5] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=5] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=6] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=6] ---
+++ enter page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=7] +++
--- leave page: [http://g.163.com/r?site=netease&affiliate=news&cat=homepage&type=logo300x250&location=7] ---
Done!
```    
What is the difference compared to setting crawling rules in `$arrJobs['link_rules']`. Answers below:    
1. Crawlers only inspect `<a>` tags, and enqueue the value of the `href` attribute, which must satisfy rules listed in the `$arrJobsb['link_rules']` array, of the tag. While crawlers do not recognise `<iframe>` tags, plus the corresponding URL is pointed to by `src` attribute of the tags;    
2. We tell the crawlers which links should be additinally followed during their run time using `$this->addAdditionalUrls($strSrc);`, rather than setting the rules before they start to work.    
####1.4 Crawling Baidu Search Engine Results
As long as you know something about the structure of a web page, you will get anything you want from the page. After looking inside the HTML codes of searching-result pages from Baidu, we can find out that every result entry locates in DOMs which has the folloing format: `<h3><a href="I am link"><em>I am description</em></a></h3>`. Thus we only need to retrieve the plaintext and `href` attribute of `<a>` tags whose direct parents are `<h3>` tags.
Please run `crawl_baidu_page.php`, which prints the searching results of 'facebook', and you will get the following output:    
```
$> php crawl_baidu_page.php 
   Facebook 
http://www.baidu.com/link?url=AtASutoPNIKCLMMz_CTeuhoe97gXt5N2JagWcZm0eUO-dvRdInYNWVhk7UVGiSNi

Facebook_百度百科
http://www.baidu.com/link?url=9D5oa_7E1ezSVwfx4hGVRtObcvmruI0UCR_cOTWEnj74p7AiWY_ESYXyvnyVHlXXHOYHh94UaZdiUpnGdS5qQa

facebook - facebook官网_facebook注册
http://www.baidu.com/link?url=3CmiG8W9me4-Xc0WkdDvsLT71hMN37s3o1M11T5VnbN-PFBnCgoCoXJ9-8iIPijf

facebook中文网 - facebook中文官网 facebook网址登陆
http://www.baidu.com/link?url=yJqsEl7U_elBeIsW4i108vaaFNTugzb8nWM8h9kXS0zDdKbBhWEUbcRm7ALY3rQF

facebook吧_百度贴吧
http://www.baidu.com/link?url=mWmpR1_PTCFQuJTmE_TarbSDvvHhhim4w15fQ8dipvJRwLY5twIb17hivcOcUGa-v_mbDS0Bfd4SVh7mjHz4mK

facebook的最新相关信息
http://www.baidu.com/link?url=ARSNH3CTzh9HyGL8VgmREUTI1JC8VNmJ3FPHJn32l_nHFnjKGWdbexnZmsQ7090JoTKVeRVYXlixLaxnjH6yDJt8ln7IJsoihEXPY9B7-m3

Facebook
http://www.baidu.com/link?url=G7GoImtCer71s9xQ0C5rlbCbGN6toa3fONlouj8nlHkIAJg3TrazM4FFw-9sjSzU

Facebook[FB]_美股实时行情_新浪财经
http://www.baidu.com/link?url=AtASutoPNIKCLMMz_CTeuh_n1s-MJ2bubaCG7gsoyh81Oj-9lYKqY4Wv8iYx8OuUhnaOL6R9M8WJTnc5qcrrF8s_vP2R9W0dURAaLW6zT5_

facebook中文网 - facebook官网注册!
http://www.baidu.com/link?url=LDR4I-ZA2VI4YuVk-hLH_SvxNwcynRZJ6qtD1go0wc68Q08viPvLh3-wXvoW3ILS

为什么中国出不了Facebook和Twitter?-月光博客
http://www.baidu.com/link?url=g7e5dKdgTPcIKOwybAPc7mk7omwz94u0xWuZ_9-nS1AGfdotydkziu7vqCRbrVK0T6rTCUSA3Al5mL4Rcl7YY_
```    
###2 Get All The Infomation of An HTML Tag
Please use example 1.3 and 1.4 as references. Actually you mainly have to know the following four techniques:    
1. xpath, it is used to describe what kind of HTML tag you are looking for, learn more about xpath: [www.w3schools.com/xsl/xpath_syntax.asp](www.w3schools.com/xsl/xpath_syntax.asp);    
2. `sel` method, all the examples above use `$page->sel('xpath query')`, after calling this method you will get an array, which will contain all the qualified DOM elements;    
3. Member `plaintext` of simplehtmldom, say `$res[$i]->plaintext`, which stores plain text that the DOM element wraps;    
4. Method `getAttribute` of simplehtmldom, say `$res[$i]->getAttribute('href')` in the `crawl_baidu_page.php` example, from which you can get the attribute of the specified tag.    
Generally speaking, once you are familiar with the above four, you handle DOMs in Phpfetcher well.
Phpfetcher parse HTMLs using simplehtmldom, an opensourced project, view it on [http://simplehtmldom.sourceforge.net/](http://simplehtmldom.sourceforge.net/) or learn more about its API with [Drupal API](http://api.drupal.psu.edu/api/drupal/modules%21contrib%21simplehtmldom%21simplehtmldom%21simple_html_dom.php/cis7)
###3 Modify User-agent
Previously I encoutered a problem that a website returned `Forbidden` like response due the forbidden user-agent of Phpfetcher, which I set to 'phpfetcher'. You can Google more about user-agent if you want.
Usually speaking, web browers have their own user-agents, say Firefox may include `Firefox` in its user-agent, Chrome may include `Chrome`. Web browers on mobile phones may have `Mobile` in their user-agents, such as `Chrome Mobile`, `Safari Mobile`, etc.
UA(user-agent) is not something holy that we can not touch, but something we can make it whatever we want.
Some websites may forbid access from some web browers, thus when you encouter a weird `Forbidden` issue, consider modify the UA of Phpfetcher, it resides in the line `'user_agent' = 'firefox'` of file `Phpfetcher/Dom/Default.php`, replace the UA `firefox` with something more convincible.
```
    protected $_arrDefaultConf = array(
            'connect_timeout' => 10, 
            'max_redirs'      => 10, 
            'return_transfer' => 1,   //need this
            'timeout'         => 15, 
            'url'             => NULL,
            'user_agent'      => 'firefox'
    );
```    
If you did not solve the problem, consider other reasons like IP forbidden.
###4 Summary
There are still lots of imperfect sides of Phpfetcher, including multi-threading, carwling with logged in states, etc.
But that is probably what makes this framework easy to learn, to maintain.
I will not deny that there are many designing problems despite of the lack of features, and I will push the project forward once more and more developers demand more and more necessary features.
Until now, this framework meets most of the demands of its little user group.
I hope you enjoy using Phpfetcher!
