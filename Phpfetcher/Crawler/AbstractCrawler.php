<?php
namespace Phpfetcher\Crawler;

use Phpfetcher\Log;

/**
 * @author xuruiqi
 * @date 2014-07-17
 * @copyright reetsee.com
 * @desc 爬虫对象的抽象类
 *       Crawler objects' abstract class
 */

abstract class AbstractCrawler
{
    protected $_arrPostFetchHooks = [];
    protected $_arrPreFetchHooks = [];
    //protected $_arrExtraInfo = array();

    /**
     * 设置爬虫的爬取规则
     * @param array $arrInput
     * @return mixed
     */
    abstract function &setFetchJobs($arrInput = []);

    /**
     * 删除一条已有的爬取规则
     * @param $arrInput
     */
    public function delFetchJobs($arrInput)
    {
        Log::notice('not implemented');
    }

    /**
     * 查看已有的爬取规则
     * @return mixed
     */
    abstract function getFetchJobs();

    /**
     * 对于每次爬取到的页面，进行的操作，这个方法需要使用者自己实现
     * @param \Phpfetcher\Page\DefaultPage $objPage
     * @return mixed
     */
    abstract function handlePage($objPage);

    /*
    public function getExtraInfo($arrInput = array()) {
        $arrOutput = array();
        foreach ($arrInput as $field) {
            $arrOutput[$field] = $this->_arrExtraInfo[$field];
        }
        return $arrOutput;
    }
     */

    /*
    public function setExtraInfo($arrInput = array()) {
        if (!is_array($arrInput) || empty($arrInput)) {
            return FALSE;
        }
        foreach ($arrInput as $key => $value) {
            $this->_arrExtraInfo[$key] = $value;
        }
        return TRUE;
    }
     */

    /*
    //修改一条已有的规则
    public function setFetchJobByName() {
        Phpfetcher_Error::notice('not implemented');
    }
     */

    /**
     * 运行爬虫
     * @param array $arrInput
     * @return mixed
     */
    abstract function &run($arrInput = []);
}
