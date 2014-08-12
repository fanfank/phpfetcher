<?php
/*
 * @author xuruiqi
 * @date 2014-07-17
 * @desc 爬虫对象的抽象类
 *       Crawler objects' abstract class
 */
abstract class Phpfetcher_Crawler_Abstract {
    protected $arrPostFetchHooks = array();
    protected $arrPreFetchHooks  = array();

    //设置爬虫的爬取规则
    abstract function setFetchJobs($arrInput);

    //删除一条已有的爬取规则
    public function delFetchJobs($arrInput) {
        Phpfetcher_Log::notice('not implemented');
    }

    //查看已有的爬取规则
    abstract function getFetchJobs();

    //对于每次爬取到的页面，进行的操作，这个方法需要使用者自己实现
    abstract function handlePage($objPage);

    /*
    //修改一条已有的规则
    public function setFetchJobByName() {
        Phpfetcher_Error::notice('not implemented');
    }
     */

    //运行爬虫
    abstract function run($arrInput = array());
}
?>
