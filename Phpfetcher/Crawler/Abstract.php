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

    //添加爬虫的爬取规则
    abstract function addFetchJobs($arrInput);

    //删除一条已有的爬取规则
    public function deleteFetchJobs($arrInput) {
        Phpfetcher_Log::notice('not implemented');
    }

    //查看已有的爬取规则
    abstract function getFetchJobs();

    /*
    //修改一条已有的规则
    public function setFetchJobByName() {
        Phpfetcher_Error::notice('not implemented');
    }
     */

    //替换爬取规则为传入的规则
    abstract function setFetchJobs($arrInput);

    //运行爬虫
    abstract function run();
}
?>
