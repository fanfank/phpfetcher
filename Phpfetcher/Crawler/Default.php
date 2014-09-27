<?php
/*
 * @author xuruiqi
 * @date 2014-07-17
 * @desc 爬虫对象的默认类
 *       Crawler objects' default class
 */
abstract class Phpfetcher_Crawler_Default extends Phpfetcher_Crawler_Abstract {
    const MAX_DEPTH = 20;
    const MAX_PAGE_NUM = -1;
    const MODIFY_JOBS_SET = 1;
    const MODIFY_JOBS_DEL = 2;
    const MODIFY_JOBS_ADD = 3;
    const DEFAULT_PAGE_CLASS = 'Phpfetcher_Page_Default';
    const ABSTRACT_PAGE_CLASS = 'Phpfetcher_Page_Abstract';

    const INT_TYPE = 1;
    const STR_TYPE = 2;
    const ARR_TYPE = 3;

    protected static $arrJobFieldTypes = array(
        'start_page' => self::STR_TYPE, 
        'link_rules' => self::ARR_TYPE, 
        'max_depth'  => self::INT_TYPE, 
        'max_pages'  => self::INT_TYPE,
    );

    /*
    protected static $arrJobDefaultFields = array(
        'max_depth' => self::MAX_DEPTH,
        'max_pages' => self::MAX_PAGE_NUM,
    );
     */


    protected $_arrFetchJobs = array();
    protected $_arrHash = array();
    //protected $_objPage = NULL; //Phpfetcher_Page_Default;

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
    public function &addFetchJobs($arrInput = array()) {
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
    public function &delFetchJobs($arrInput = array()) {
        return $this->_modifyFetchJobs($arrInput, self::MODIFY_JOBS_DEL);
    }

    public function getFetchJobByName($job_name) {
        return $this->_arrFetchJobs[$strJobName];
    }

    public function getFetchJobs() {
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
    protected function &_modifyFetchJobs($arrInput = array(), $intOptType) {
        $arrInvalidJobs = array();
        if ($intOptType === self::MODIFY_JOBS_SET || $intOptType === self::MODIFY_JOBS_ADD) {
            if ($intOptType === self::MODIFY_JOBS_SET) {
                $this->_arrFetchJobs = array();
            }
            foreach ($arrInput as $job_name => $job_rules) {
                $this->_correctJobParam($job_rules);
                if ($this->_isJobValid($job_rules)) {
                    $this->_arrFetchJobs[$job_name] = $job_rules;
                } else {
                    $arrInvalidJobs[] = $job_name;
                }
            }
        } else if ($intOptType === self::MODIFY_JOBS_DEL) {
            foreach ($arrInput as $job_name) {
                unset($this->_arrFetchJobs[$job_name]);
            }
        } else {
            Phpfetcher_Log::warning("Unknown options for fetch jobs [{$intOptType}]");
        }


        if (!empty($arrInvalidJobs)) {
            Phpfetcher_Log::notice('Invalid jobs:' . implode(',', $arrInvalidJobs));
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
    public function &setFetchJobs($arrInput = array()) {
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
    public function &run($arrInput = array()) {
        if (empty($this->_arrFetchJobs)) {
            Phpfetcher_Log::warning("No fetch jobs.");
            return $this;
        }

        //构建Page对象
        $objPage = NULL;
        $strPageClassName = self::DEFAULT_PAGE_CLASS;
        if (!empty($arrInput['page_class_name'])) {
            $strPageClassName = strval($arrInput['page_class_name']);
        }
        try {
            if (!class_exists($strPageClassName, TRUE)) {
                throw new Exception("[$strPageClassName] class not exists!");
            }

            $objPage = new $strPageClassName;
            if (!($objPage instanceof Phpfetcher_Page_Abstract)) {
                throw new Exception("[$strPageClassName] is not an instance of " . self::ABSTRACT_PAGE_CLASS);
            }
        } catch (Exception $e) {
            Phpfetcher_Log::fatal($e->getMessage());
            return $this;
        }

        //初始化Page对象
        $arrPageConf = empty($arrInput['page_conf']) ? array() : $arrInput['page_conf'];
        $objPage->init();
        if (!empty($arrPageConf)) {
            if(isset($arrPageConf['url'])) {
                unset($arrPageConf['url']);
            }
            $objPage->setConf($arrPageConf);
        }

        //遍历任务队列
        foreach ($this->_arrFetchJobs as $job_name => $job_rules) {
            if (!($this->_isJobValid($job_rules))) {
                Phpfetcher_Log::warning("Job rules invalid [" . serialize($job_rules) . "]");
                continue;
            }

            $intDepth   = 0;
            $intPageNum = 0;
            $arrIndice = array(0, 1);
            $arrJobs = array(
                0 => array($job_rules['start_page']),   
                1 => array(),
            );

            //开始爬取
            while (!empty($arrJobs[$arrIndice[0]])
                && ($job_rules['max_depth'] === -1 || $intDepth < $job_rules['max_depth']) 
                && ($job_rules['max_pages'] === -1 || $intPageNum < $job_rules['max_pages'])) {
                $intDepth += 1;
                $intPopIndex = $arrIndice[0];
                $intPushIndex = $arrIndice[1];
                $arrJobs[$intPushIndex] = array();
                foreach ($arrJobs[$intPopIndex] as $url) {
                    if (!($job_rules['max_pages'] === -1 || $intPageNum < $job_rules['max_pages'])) {
                        break;
                    }
                    $objPage->setUrl($url);
                    $objPage->read();

                    //获取所有的超链接
                    $arrLinks = $objPage->getHyperLinks();
                    
                    //匹配超链接
                    foreach ($job_rules['link_rules'] as $link_rule) {
                        foreach ($arrLinks as $link) {
                            if (preg_match($link_rule, $link) === 1
                            && !$this->getHash($link)) {
                                $this->setHash($link, true);
                                $arrJobs[$intPushIndex][] = $link;
                            }
                        }
                    }

                    //由用户实现handlePage函数
                    $objPage->setExtraInfo(array('job_name' => $job_name ));
                    $this->handlePage($objPage);
                    $intPageNum += 1;
                } 
                self::_swap($arrIndice[0], $arrIndice[1]);
            }
        }
        return $this;
    }

    protected function _correctJobParam(&$job_rules) {
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
    protected function _isJobValid($arrRule) {
        foreach (self::$arrJobFieldTypes as $field => $type) {
            if (!isset($arrRule[$field]) || ($type === self::ARR_TYPE && !is_array($arrRule[$field]))) {
                return FALSE;
            }
        }
        return TRUE;
    }

    protected static function _swap(&$a, &$b) {
        $tmp = $a;
        $a = $b;
        $b = $tmp;
    }

    public function getHash($strRawKey) {
        $strRawKey = strval($strRawKey);
        $strKey = md5($strRawKey);
        if (isset($this->_arrHash[$strKey])) {
            return $this->_arrHash[$strKey];
        }
        return NULL;
    }

    public function setHash($strRawKey, $value) {
        $strRawKey = strval($strRawKey);
        $strKey = md5($strRawKey);
        $this->_arrHash[$strKey] = $value;
    }

    public function clearHash() {
        $this->_arrHash = array();
    }
}
?>
