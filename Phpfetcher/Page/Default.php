<?php
/*
 * @author xuruiqi
 * @date   2014.06.28
 * @abstract Default Page class
 */
class Phpfetcher_Page_Default extends Phpfetcher_Page_Abstract {

    protected static $_arrAlias2Field = array(
        /* bool */
        'include_header' => array('curl_opt', CURLOPT_HEADER),
        'exclude_body'   => array('curl_opt', CURLOPT_NOBODY),
        'is_post'        => array('curl_opt', CURLOPT_POST),
        'is_verbose'     => array('curl_opt', CURLOPT_VERBOSE),

        /* int */
        'buffer_size'       => array('curl_opt', CURLOPT_BUFFERSIZE),
        'connect_timeout'   => array('curl_opt', CURLOPT_CONNECTTIMEOUT),
        'connect_timeout_ms' => array('curl_opt', CURLOPT_CONNECTTIMEOUT_MS),
        'dns_cache_timeout' => array('curl_opt', CURLOPT_DNS_CACHE_TIMEOUT),
        'max_redirs'        => array('curl_opt', CURLOPT_MAXREDIRS),
        'port'              => array('curl_opt', CURLOPT_PORT),
        'timeout'           => array('curl_opt', CURLOPT_TIMEOUT),
        'timeout_ms'        => array('curl_opt', CURLOPT_TIMEOUT_MS),

        /* string */
        'cookie'            => array('curl_opt', CURLOPT_COOKIE),
        'cookie_file'       => array('curl_opt', CURLOPT_COOKIEFILE),
        'cookie_jar'        => array('curl_opt', CURLOPT_COOKIEJAR),
        'post_fields'       => array('curl_opt', CURLOPT_POSTFIELDS),
        'url'               => array('curl_opt', CURLOPT_URL),
        'user_agent'        => array('curl_opt', CURLOPT_USERAGENT),
        'user_pwd'          => array('curl_opt', CURLOPT_USERPWD),

        /* array */
        'http_header'       => array('curl_opt', CURLOPT_HTTPHEADER),

        /* stream resource */
        'file'              => array('curl_opt', CURLOPT_FILE),

        /* function or a Closure */
        'write_function'    => array('curl_opt', CURLOPT_WRITEFUNCTION),
    );

    protected $_arrDefaultConf = array(
        'curl_opt' => array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_RETURNTRANSFER => 0,   //need this
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_URL            => NULL,
        ),
    );

    protected $_arrConf = array();

    public __construct() {}
    public __destruct() {}

    /**
     * @author xuruiqi
     * @param in
     *      string $alias: target alias
     * @param out
     *      array: 
     *          int   errcode: error code, 0 represents success
     *          string errmsg: error message
     *          mixed     res: corresponding field value
     * @abstract get an alias' corresponding field value.
     */
    protected function _alias2Field($alias) {
        $alias = strval($alias);

        if (!isset($this->_arrAlias2Field($alias))) {
            $errcode = Phpfetcher_Error::ERR_INVALID_FIELD;
            $arrOutput = array(
                'errcode' => $errcode,    
                'errmsg'  => Phpfetcher_Error::getErrmsg($errcode),
            );
            return $arrOutput;
        }


        $arrOutput = array(
            'errcode' => Phpfetcher_Error::ERR_SUCCESS, 
            'errmsg'  => Phpfetcher_Error::getErrmsg(Phpfetcher_Error::ERR_SUCCESS),
        );
    }

    /**
     * @author xuruiqi
     * @abstract get configurations.
     */
    public function getConf() {
        return $this->_arrConf;
    }

    /**
     * @author xuruiqi
     * @param in $key: specified field
     * @param out
     *      bool  : false when field doesn't exist
     *      mixed : otherwise
     * @abstract get a specified configuration.
     */
    public function getConfField($key) {
        if (isset($_arrConf[$key])) {
            return $this->_arrConf[$key];
        } else {
            return false;
        }
    }

    /**
     * @author xuruiqi
     * @param in
     * @param out
     *      string : current page's url
     * @abstract get this page's URL.
     */
    public function getUrl() {
        return $this->_arrConf[$url];
    }

    /**
     * @author xuruiqi
     * @param in
     *      $conf : array, configurations
     * @param out
     * @abstract initialize this instance with specified or default configuration
     */
    public function init($conf = array()) {
        $this->_arrConf = $this->_arrDefaultConf;

        foreach($conf as $k => $v) {
            if (isset($this->_arrConf[$k])) {
                $this->_arrConf[$k] = $v;
            } else {
                //TODO
                //Logging
            }
        }
    }

    /**
     * TODO
     * @author xuruiqi
     * @param in
     *      array $tags : 
     * @param out
     *      array : specified tags' contents
     * @abstract select spcified tags' contents via xpath.
     */
    public function msel($tags) {

    }

    /**
     * TODO
     * @author xuruiqi
     * @param in
     * @param out
     * @abstract get page's content, and save it into member variable <content>
     */
    public function read() {

    }

    /**
     * TODO
     * @author xuruiqi
     * @param in
     *      string $tag : specifed tag
     * @param out
     *      array : tag's contents 
     * @abstract select spcified tag's contents via xpath.
     */
    public function sel($tag) {

    }

    /**
     * TODO
     * @author xuruiqi
     * @param in
     *      array $conf : configurations
     * @param out
     * @abstract set configurations.
     */
    public function setConf($conf = array()) {
        foreach($conf as $k => $v) {
            if (isset($this->_arrConf[$k])) {
                $this->_arrConf[$k] = $v;
            } else {
                //TODO
                //Logging
            }
        }

        //need re-init?
    }

    /**
     * @author xuruiqi
     * @param in
     *      string $url : the URL
     * @param out
     * @abstract set this page's URL.
     */
    public function setUrl($url) {
        $this->_arrConf['url'] = $url;
        //need re-init?
    }
}
?>
