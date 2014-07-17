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
    abstract function addFetchRules($arrInput);

    //删除一条已有的爬取规则
    public function deleteFetchRule($rule_pos) {
        Phpfetcher_Error::notice('deleteFetchRule not implemented');
    }

    //查看已有的爬取规则
    abstract function getFetchRules();

    //修改一条已有的规则
    public function modifyFetchRule($rule_pos, $new_rule) {
        Phpfetcher_Error::notice('modifyFetchRule not implemented');
    }

    //替换爬取规则为传入的规则
    abstract function replaceFetchRules($arrInput);

    //运行爬虫
    abstract function run();
}
?>
