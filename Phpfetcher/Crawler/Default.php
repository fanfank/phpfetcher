<?php
/*
 * @author xuruiqi
 * @date 2014-07-17
 * @desc 爬虫对象的默认类
 *       Crawler objects' default class
 */
abstract class Phpfetcher_Crawler_Default {
    /**
     * @author xuruiqi
     * @param
     *      array $arrInput:
     *          array 0 :
     *              string 'start_page',    //爬虫的起始页面
     *              array  'regex_rules':   //爬虫跟踪的超链接需要满足的正则表达式，依次检查规则，匹配其中任何一条即可
     *                  string 0,   //正则表达式1
     *                  string 1,   //正则表达式2
     *                  ...
     *                  string n-1, //正则表达式n
     *              int    'max_depth' ,    //爬虫最大的跟踪深度，目前限制最大值不超过20
     *              int    'max_pages' ,    //最多爬取的页面数，默认指定为-1，表示没有限制
     *          array 1 :
     *              ...
     *              ...
     *          ...
     *          array n-1:
     *              ...
     *              ...
     *
     * @return
     *      Object $this : returns the instance itself
     * @desc add by what rules the crawler should fetch the pages
     */
    public function addFetchRules($arrInput) {
        //TODO
    }

}
?>
