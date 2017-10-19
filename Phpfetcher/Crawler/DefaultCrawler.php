<?php

namespace Phpfetcher\Crawler;

use Phpfetcher\Log;
use Phpfetcher\Page\AbstractPage;
use Phpfetcher\Page\DefaultPage;
use Phpfetcher\Util\Trie;

/**
 * @author xuruiqi
 * @date 2014-07-17
 * @copyright reetsee.com
 * @desc 爬虫对象的默认类
 *       Crawler objects' default class
 */
abstract class DefaultCrawler extends AbstractCrawler
{
    const MAX_DEPTH = 20;
    const MAX_PAGE_NUM = -1;
    const MODIFY_JOBS_SET = 1;
    const MODIFY_JOBS_DEL = 2;
    const MODIFY_JOBS_ADD = 3;
    const DEFAULT_PAGE_CLASS = DefaultPage::class;
    const ABSTRACT_PAGE_CLASS = AbstractPage::class;

    const INT_TYPE = 1;
    const STR_TYPE = 2;
    const ARR_TYPE = 3;

    protected static $arrJobFieldTypes = [
        'start_page' => self::STR_TYPE,
        'link_rules' => self::ARR_TYPE,
        'max_depth'  => self::INT_TYPE,
        'max_pages'  => self::INT_TYPE,
    ];

    /*
    protected static $arrJobDefaultFields = array(
        'max_depth' => self::MAX_DEPTH,
        'max_pages' => self::MAX_PAGE_NUM,
    );
     */

    protected $_arrFetchJobs = [];
    protected $_arrHash = [];
    protected $_arrAdditionalUrls = [];
    protected $_objSchemeTrie = []; //合法url scheme的字典树

    //protected $_objPage = NULL; //Phpfetcher_Page_Default;

    public function __construct($arrInitParam = [])
    {
        if (!isset($arrInitParam['url_schemes'])) {
            $arrInitParam['url_schemes'] = ["http", "https", "ftp"];
        }

        $this->_objSchemeTrie =
            new Trie($arrInitParam['url_schemes']);
    }

    /**
     * @author xuruiqi
     * @param
     *      array $arrInput:
     *          array <任务名1> :
     *              string 'start_page',    //爬虫的起始页面
     *              array  'link_rules':   //爬虫跟踪的超链接需要满足的正则表达式，依次检查规则，匹配其中任何一条即可
     *                  string 0,   //正则表达式1
     *                  string 1,   //正则表达式2
     *                  ...
     *                  string n-1, //正则表达式n
     *              int    'max_depth' ,    //爬虫最大的跟踪深度，目前限制最大值不超过20
     *              int    'max_pages' ,    //最多爬取的页面数，默认指定为-1，表示没有限制
     *          array <任务名2> :
     *              ...
     *              ...
     *          ...
     *          array <任务名n-1>:
     *              ...
     *              ...
     *
     * @return
     *      Object $this : returns the instance itself
     * @desc add by what rules the crawler should fetch the pages
     *       if a job has already been in jobs queue, new rules will
     *       cover the old ones.
     */
    public function &addFetchJobs($arrInput = [])
    {
        return $this->_modifyFetchJobs($arrInput, self::MODIFY_JOBS_ADD);
    }

    /**
     * @author xuruiqi
     * @param
     *      array $arrInput :
     *          mixed 0 :
     *              任务名
     *          mixed 1 :
     *              任务名
     *          ... ...
     * @return
     *      Object $this : returns the instance itself
     * @desc delete fetch rules according to job names
     */
    public function &delFetchJobs($arrInput = [])
    {
        return $this->_modifyFetchJobs($arrInput, self::MODIFY_JOBS_DEL);
    }

    public function getFetchJobByName($job_name)
    {
        //@todo
        return $this->_arrFetchJobs[$strJobName];
    }

    public function getFetchJobs()
    {
        return $this->_arrFetchJobs;
    }

    /*
    public function handlePage() {
        //由用户继承本类并实现此方法
    }
     */

    /**
     * @author xuruiqi
     * @param :
     *      //$intOptType === MODIFY_JOBS_SET|MODIFY_JOBS_ADD,
     *        $arrInput参见addFetchJobs的入参$arrInput
     *      //$intOptType === MODIFY_JOBS_DEL,
     *        $arrInput参见delFetchJobs的入参$arrInput
     *
     * @return
     *      Object $this : returns the instance itself
     * @desc set fetch rules.
     */
    protected function &_modifyFetchJobs($arrInput = [], $intOptType)
    {
        $arrInvalidJobs = [];
        if ($intOptType === self::MODIFY_JOBS_SET || $intOptType === self::MODIFY_JOBS_ADD) {
            if ($intOptType === self::MODIFY_JOBS_SET) {
                $this->_arrFetchJobs = [];
            }
            foreach ($arrInput as $job_name => $job_rules) {
                $this->_correctJobParam($job_rules);
                if ($this->_isJobValid($job_rules)) {
                    $this->_arrFetchJobs[$job_name] = $job_rules;
                } else {
                    $arrInvalidJobs[] = $job_name;
                }
            }
        } else {
            if ($intOptType === self::MODIFY_JOBS_DEL) {
                foreach ($arrInput as $job_name) {
                    unset($this->_arrFetchJobs[$job_name]);
                }
            } else {
                Log::warning("Unknown options for fetch jobs [{$intOptType}]");
            }
        }


        if (!empty($arrInvalidJobs)) {
            Log::notice('Invalid jobs:'.implode(',', $arrInvalidJobs));
        }

        return $this;
    }

    /**
     * @author xuruiqi
     * @param : 参见addFetchJobs的入参$arrInput
     *
     * @return
     *      Object $this : returns the instance itself
     * @desc set fetch jobs.
     */
    public function &setFetchJobs($arrInput = [])
    {
        return $this->_modifyFetchJobs($arrInput, self::MODIFY_JOBS_SET);
    }

    /**
     * @author xuruiqi
     * @param
     *      array $arrInput : //运行设定
     *          string 'page_class_name' : //指定要使用的Page类型，必须是
     *                                     //Phpfetcher_Page_Abstract的
     *                                     //子类
     *          [array 'page_conf'] : //Page调用setConf时的输入参数，可选
     * @return
     *      obj $this
     * @desc
     */
    public function &run($arrInput = [])
    {
        if (empty($this->_arrFetchJobs)) {
            Log::warning("No fetch jobs.");

            return $this;
        }

        //构建Page对象
        $objPage = null;
        $strPageClassName = self::DEFAULT_PAGE_CLASS;
        if (!empty($arrInput['page_class_name'])) {
            $strPageClassName = strval($arrInput['page_class_name']);
        }
        try {
            if (!class_exists($strPageClassName, true)) {
                throw new \Exception("[$strPageClassName] class not exists!");
            }

            /**
             * @var $objPage \Phpfetcher\Page\DefaultPage
             */
            $objPage = new $strPageClassName;
            if (!($objPage instanceof AbstractPage)) {
                throw new \Exception("[$strPageClassName] is not an instance of ".self::ABSTRACT_PAGE_CLASS);
            }
        } catch (\Exception $e) {
            Log::fatal($e->getMessage());

            return $this;
        }

        //初始化Page对象
        $arrPageConf = empty($arrInput['page_conf']) ? [] : $arrInput['page_conf'];
        $objPage->init();
        if (!empty($arrPageConf)) {
            if (isset($arrPageConf['url'])) {
                unset($arrPageConf['url']);
            }
            $objPage->setConf($arrPageConf);
        }

        //遍历任务队列
        foreach ($this->_arrFetchJobs as $job_name => $job_rules) {
            if (!($this->_isJobValid($job_rules))) {
                Log::warning("Job rules invalid [".serialize($job_rules)."]");
                continue;
            }

            //检查是否需要设置curl配置
            if (!empty($job_rules['page_conf'])) {
                $objPage->setConf($job_rules['page_conf']);
            }

            $intDepth = 0;
            $intPageNum = 0;
            $arrIndice = [0, 1];
            $arrJobs = [
                0 => [$job_rules['start_page']],
                1 => [],
            ];

            //开始爬取
            while (!empty($arrJobs[$arrIndice[0]])
                && ($job_rules['max_depth'] === -1 || $intDepth < $job_rules['max_depth'])
                && ($job_rules['max_pages'] === -1 || $intPageNum < $job_rules['max_pages'])) {

                $intDepth += 1;
                $intPopIndex = $arrIndice[0];
                $intPushIndex = $arrIndice[1];
                $arrJobs[$intPushIndex] = [];
                foreach ($arrJobs[$intPopIndex] as $url) {
                    if (!($job_rules['max_pages'] === -1 || $intPageNum < $job_rules['max_pages'])) {
                        break;
                    }
                    $objPage->setUrl($url);
                    $objPage->read();

                    //获取所有的超链接
                    $arrLinks = $objPage->getHyperLinks();

                    //解析当前URL的各个组成部分，以应对超链接中存在站内链接
                    //的情况，如"/entry"等形式的URL
                    $strCurUrl = $objPage->getUrl();
                    $arrUrlComponents = parse_url($strCurUrl);

                    //匹配超链接
                    foreach ($job_rules['link_rules'] as $link_rule) {
                        foreach ($arrLinks as $link) {
                            if (substr($link, 0, 2) == "//") {
                                $link = substr($link, 1);
                            }

                            if (preg_match($link_rule, $link) === 1
                                && !$this->getHash($link)) {

                                //拼出实际的URL
                                $real_link = $link;

                                //不使用strpos，防止扫描整个字符串
                                //这里只需要扫描前6个字符即可
                                $colon_pos = false;
                                for ($i = 0; $i <= 5; ++$i) {
                                    if ($link[$i] == ':') {
                                        $colon_pos = $i;
                                        break;
                                    }
                                }

                                if ($colon_pos === false
                                    || !$this->_objSchemeTrie->has(
                                        substr($link, 0, $colon_pos)
                                    )) {
                                    //将站内地址转换为完整地址
                                    $real_link = $arrUrlComponents['scheme']
                                        ."://"
                                        .$arrUrlComponents['host']
                                        .(isset($arrUrlComponents['port'])
                                        && strlen($arrUrlComponents['port']) != 0 ?
                                            ":{$arrUrlComponents['port']}" :
                                            "")
                                        .($link[0] == '/' ?
                                            $link : "/$link");
                                }

                                $this->setHash($link, true);
                                $this->setHash($real_link, true);
                                $arrJobs[$intPushIndex][] = $real_link;
                            }
                        }
                    }

                    //由用户实现handlePage函数
                    $objPage->setExtraInfo(['job_name' => $job_name]);
                    $this->handlePage($objPage);
                    $intPageNum += 1;
                }

                if (!empty($this->_arrAdditionalUrls)) {
                    $arrJobs[$intPushIndex] =
                        array_merge(
                            $arrJobs[$intPushIndex],
                            $this->_arrAdditionalUrls
                        );
                    $this->_arrAdditionalUrls = [];
                }

                self::_swap($arrIndice[0], $arrIndice[1]);
            }
        }

        return $this;
    }

    protected function _correctJobParam(&$job_rules)
    {
        /*
        foreach (self::$arrJobDefaultFields as $field => $value) {
            if (!isset($job_rules[$field]) || ($job_rules['']))
        }
         */
        if (!isset($job_rules['max_depth']) || (self::MAX_DEPTH !== -1 && self::MAX_DEPTH < $job_rules['max_depth'])) {
            $job_rules['max_depth'] = self::MAX_DEPTH;
        }

        if (!isset($job_rules['max_pages']) || (self::MAX_PAGE_NUM !== -1 && self::MAX_PAGE_NUM < $job_rules['max_pages'])) {
            $job_rules['max_pages'] = self::MAX_PAGE_NUM;
        }
    }

    /**
     * @author xuruiqi
     * @desc check if a rule is valid
     */
    protected function _isJobValid($arrRule)
    {
        foreach (self::$arrJobFieldTypes as $field => $type) {
            if (!isset($arrRule[$field]) || ($type === self::ARR_TYPE && !is_array($arrRule[$field]))) {
                return false;
            }
        }

        return true;
    }

    protected static function _swap(&$a, &$b)
    {
        $tmp = $a;
        $a = $b;
        $b = $tmp;
    }

    public function getHash($strRawKey)
    {
        $strRawKey = strval($strRawKey);
        $strKey = md5($strRawKey);
        if (isset($this->_arrHash[$strKey])) {
            return $this->_arrHash[$strKey];
        }

        return null;
    }

    public function setHash($strRawKey, $value)
    {
        $strRawKey = strval($strRawKey);
        $strKey = md5($strRawKey);
        $this->_arrHash[$strKey] = $value;
    }

    public function setHashIfNotExist($strRawKey, $value)
    {
        $strRawKey = strval($strRawKey);
        $strKey = md5($strRawKey);

        $bolExist = true;
        if (!isset($this->_arrHash[$strKey])) {
            $this->_arrHash[$strKey] = $value;
            $bolExist = false;
        }

        return $bolExist;
    }

    public function clearHash()
    {
        $this->_arrHash = [];
    }

    public function addAdditionalUrls($url)
    {
        if (!is_array($url)) {
            $url = [$url];
        }

        $intAddedNum = 0;
        foreach ($url as $strUrl) {
            $strUrl = strval($strUrl);

            if ($this->setHashIfNotExist($strUrl, true) === false) {
                $this->_arrAdditionalUrls[] = $strUrl;
                ++$intAddedNum;
            }
        }

        return $intAddedNum;
    }
}
