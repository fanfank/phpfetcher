<?php
/*
 * @author xuruiqi
 * @date 2014-07-17
 * @desc 爬虫对象的默认类
 *       Crawler objects' default class
 */
abstract class Phpfetcher_Crawler_Default {

    const MAX_DEPTH = 20;
    const MAX_PAGE_NUM = -1;

    protected $_arrFetchJobs = array();

    /**
     * @author xuruiqi
     * @param
     *      array $arrInput:
     *          array <任务名1> :
     *              string 'start_page',    //爬虫的起始页面
     *              array  'regex_rules':   //爬虫跟踪的超链接需要满足的正则表达式，依次检查规则，匹配其中任何一条即可
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
        return $this->setFetchJobs($arrInput, FALSE);
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
        //$arrNotFoundJobs = array();
        foreach ($arrInput as $job_name) {
            unset($this->_arrFetchJobs[$job_name]);
        }
        return $this;
    }

    public function getFetchJobByName($job_name) {
        return $this->_arrFetchJobs[$strJobName];
    }

    public function getFetchJobs() {
        return $this->_arrFetchJobs;
    }

    /**
     * @author xuruiqi
     * @param : 参见addFetchJobs的入参$arrInput
     *
     * @return
     *      Object $this : returns the instance itself
     * @desc set fetch rules.
     */
    public function &setFetchJobs($arrInput = array(), $bolClearPrevious = TRUE) {
        if ($bolClearPrevious) {
            $arrInvalidJobs = array();
        }
        $this->_arrFetchJobs = array();
        foreach ($arrInput as $job_name => $job_rules) {
            if ($this->_isJobValid($job_rules)) {
                $this->_arrFetchJobs[$job_name] = $job_rules;
            } else {
                $arrInvalidJobs[] = $job_name;
            }
        }
        Phpfetcher_Log::notice('Invalid jobs:' . implode(',', $arrInvalidJobs));
        return $this;
    }

    /**
     * @author xuruiqi
     * @return
     * @desc
     */
    public function &run($arrInput = array()) {

    }


    /**
     * @author xuruiqi
     * @desc check if a rule is valid
     */
    protected function _isJobValid($arrRule) {
        if (empty($arrRule['start_page']) || !is_array($arrRule['regex_rules']) || empty($arrRule['regex_rules'])) {
            return FALSE;
        }
        return TRUE;
    }

}
?>
