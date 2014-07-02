<?php
/*
 * @author xuruiqi
 * @date   2014.06.28
 * @abstract Default Page class
 */
class Phpfetcher_Page_Default extends Phpfetcher_Page_Abstract {

    protected static $_arrField2CurlOpt = array(
        /* bool */
        'include_header' => CURLOPT_HEADER,
        'exclude_body'   => CURLOPT_NOBODY,
        'is_post'        => CURLOPT_POST,
        'is_verbose'     => CURLOPT_VERBOSE,
        'return_transfer'=> CURLOPT_RETURNTRANSFER,

        /* int */
        'buffer_size'       => CURLOPT_BUFFERSIZE,
        'connect_timeout'   => CURLOPT_CONNECTTIMEOUT,
        'connect_timeout_ms' => CURLOPT_CONNECTTIMEOUT_MS,
        'dns_cache_timeout' => CURLOPT_DNS_CACHE_TIMEOUT,
        'max_redirs'        => CURLOPT_MAXREDIRS,
        'port'              => CURLOPT_PORT,
        'timeout'           => CURLOPT_TIMEOUT,
        'timeout_ms'        => CURLOPT_TIMEOUT_MS,

        /* string */
        'cookie'            => CURLOPT_COOKIE,
        'cookie_file'       => CURLOPT_COOKIEFILE,
        'cookie_jar'        => CURLOPT_COOKIEJAR,
        'post_fields'       => CURLOPT_POSTFIELDS,
        'url'               => CURLOPT_URL,
        'user_agent'        => CURLOPT_USERAGENT,
        'user_pwd'          => CURLOPT_USERPWD,

        /* array */
        'http_header'       => CURLOPT_HTTPHEADER,

        /* stream resource */
        'file'              => CURLOPT_FILE,

        /* function or a Closure */
        'write_function'    => CURLOPT_WRITEFUNCTION,
    );

    protected $_arrDefaultConf = array(
            'connect_timeout' => 10,
            'max_redirs'      => 10,
            'return_transfer' => 0,   //need this
            'timeout'         => 15,
            'url'             => NULL,
    );

    protected $_arrConf    = array();
    protected $_curlHandle = NULL;
    protected $_bolCloseCurlHandle = FALSE;

    public __construct() {}
    public __destruct() {
        if ($this->$_bolCloseCurlHandle) {
            curl_close($this->_curlHandle);
        }
    }

    public static function formatRes($data, $errcode, $errmsg = NULL) {
        if ($errmsg === NULL) {
            $errmsg = Phpfetcher_Error::getErrmsg($errcode);
        }
        return array('errcode' => $errcode, 'errmsg' => $errmsg, 'res' => $data);
    }


    /**
     * @author xuruiqi
     * @param in
     *      string $key: target conf option
     * @param out
     *      array: 
     *          int   errcode: error code, 0 represents success
     *          string errmsg: error message
     *          mixed     res: corresponding field value
     * @abstract get a corresponding field value.
     */
    protected function _getConfField($key) {
        /*
        // if $key is not an alias

        // $key is an alias
        $key = strval($key);

        if (!isset($this->_arrAlias2Field($key))) {
            return self::formatRes(NULL, Phpfetcher_Error::ERR_INVALID_FIELD);
        }

        $target = $this->_arrConf;
        foreach ($this->_arrAlias2Field[$key] as $field) {
            if (isset($target[$field])) {
                $target = $target[$field];
            } else {
                return self::formatRes(NULL, Phpfetcher_Error::ERR_FIELD_NOT_SET);
            }
        }
        return self::formatRes($target, Phpfetcher_Error::ERR_SUCCESS);
         */
    }

    //TODO
    protected function _setConfField($key) {

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
        if (isset($this->_arrConf($key))) {
            return self::formatRes($this->_arrConf[$key], Phpfetcher_Error::ERR_SUCCESS);
        } else {
            return self::formatRes(NULL, Phpfetcher_Error::ERR_FIELD_NOT_SET);
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
        return $this->getConfField['url'];
    }

    /**
     * @author xuruiqi
     * @param in
     *      array $conf : configurations
     *      bool  $clear_default : whether to clear default options not set in $conf
     * @param out
     * @abstract initialize this instance with specified or default configuration
     */
    public function init($curl_handle = NULL, $conf = array()) {
        $this->_curlHandle = $curl_handle;
        if (empty($this->_curlHandle)) {
            $this->_curlHandle = curl_init();
            $this->_bolCloseCurlHandle = TRUE;
        }
        $this->_arrConf = $this->_arrDefaultConf;

        $this->msetConf($conf);

        return $this;
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
     * @author xuruiqi
     * @param in
     *      array $conf : configurations
     *      bool  $clear_previous_conf : if TRUE, then before set $conf, reset current configuration to its default value
     * @param out
     *      array : previous conf
     * @abstract set configurations.
     */
    public function msetConf($conf = array(), $clear_previous_conf = FALSE) {
        $previous_conf = $this->_arrConf;
        if ($clear_previous_conf === TRUE) {
            $this->_arrConf = $this->_arrDefaultConf;
        }
        foreach ($conf as $k => $v) {
            $this->_arrConf[$k] = $v;
        }

        $bolRes = TRUE;
        if ($clear_previous_conf === TRUE) {
            $bolRes = $this->_msetConf($this->_arrConf);
        } else {
            $bolRes = $this->_msetConf($conf);
        }

        if ($bolRes != TRUE) {
            $this->_arrConf = $previous_conf;
            $this->_msetConf($this->_arrConf);
            return $bolRes;
        }

        return $previous_conf;
    }

    protected function _msetConf($conf = array()) {
        $arrCurlOpts = array();
        foreach ($conf as $k => $v) {
            if (isset($this->_arrField2CurlOpt[$k])) {
                $arrCurlOpts[$this->_arrField2CurlOpt[$k]] = $v;
            } else {
                //currently only curl options can be set
                $arrCurlOpts[$k] = $v;
            }
        }
        return curl_setopt_array($arrCurlOpts);
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

    public function setConf($field, $value) {
        $this->_arrConf[$field] = $value;
        return $this->_setConf($field, $value);
    }

    protected function _setConf($field, $value) {
        if (isset(self::$_arrField2CurlOpt[$field])) {
            return curl_setopt($this->_curlHandle, self::$_arrField2CurlOpt[$field], $value);
        } else {
            //currently only curl options can be set
            return curl_setopt($this->_curlHandle, $field, $value);
        }
    }

    /**
     * @author xuruiqi
     * @param in
     *      string $url : the URL
     * @param out
     *      string : previous URL
     * @abstract set this page's URL.
     */
    public function setUrl($url) {
        $previous_url = $this->_arrConf['url'];
        $this->setConf('url', $url);
        return $previous_url;
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

}
?>
