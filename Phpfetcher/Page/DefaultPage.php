<?php
namespace Phpfetcher\Page;

use Phpfetcher\Dom\SimpleHtmlDom;
use Phpfetcher\Error;
use Phpfetcher\Log;

/**
 * @author xuruiqi
 * @date   2014.06.28
 * @copyright reetsee.com
 * @desc Default Page class
 */

class DefaultPage extends AbstractPage
{

    protected static $_arrField2CurlOpt = [
        /* bool */
        'include_header'     => CURLOPT_HEADER,
        'exclude_body'       => CURLOPT_NOBODY,
        'is_post'            => CURLOPT_POST,
        'is_verbose'         => CURLOPT_VERBOSE,
        'return_transfer'    => CURLOPT_RETURNTRANSFER,

        /* int */
        'buffer_size'        => CURLOPT_BUFFERSIZE,
        'connect_timeout'    => CURLOPT_CONNECTTIMEOUT,
        'connect_timeout_ms' => CURLOPT_CONNECTTIMEOUT_MS,
        'dns_cache_timeout'  => CURLOPT_DNS_CACHE_TIMEOUT,
        'max_redirs'         => CURLOPT_MAXREDIRS,
        'port'               => CURLOPT_PORT,
        'timeout'            => CURLOPT_TIMEOUT,
        'timeout_ms'         => CURLOPT_TIMEOUT_MS,

        /* string */
        'cookie'             => CURLOPT_COOKIE,
        'cookie_file'        => CURLOPT_COOKIEFILE,
        'cookie_jar'         => CURLOPT_COOKIEJAR,
        'post_fields'        => CURLOPT_POSTFIELDS,
        'url'                => CURLOPT_URL,
        'user_agent'         => CURLOPT_USERAGENT,
        'user_pwd'           => CURLOPT_USERPWD,

        /* array */
        'http_header'        => CURLOPT_HTTPHEADER,

        /* stream resource */
        'file'               => CURLOPT_FILE,

        /* function or a Closure */
        'write_function'     => CURLOPT_WRITEFUNCTION,

        /* https */
        'ssl_verifypeer'     => CURLOPT_SSL_VERIFYPEER,
    ];

    protected $_arrDefaultConf = [
        'connect_timeout' => 10,
        'max_redirs'      => 10,
        'return_transfer' => 1,   //need this
        'timeout'         => 15,
        'url'             => null,
        'user_agent'      => 'firefox',
        'ssl_verifypeer'  => false,
    ];

    protected $_arrConf = [];
    protected $_arrExtraInfo = [];
    protected $_bolCloseCurlHandle = false;
    protected $_curlHandle = null;
    /**
     * @var $_dom \simple_html_dom
     */
    protected $_dom = null;

    //protected $_xml        = NULL;

    public function __construct()
    {
    }

    public function __destruct()
    {
        if ($this->_bolCloseCurlHandle) {
            curl_close($this->_curlHandle);
        }
    }

    public static function formatRes($data, $errcode, $errmsg = null)
    {
        if ($errmsg === null) {
            $errmsg = Error::getErrmsg($errcode);
        }

        return ['errcode' => $errcode, 'errmsg' => $errmsg, 'res' => $data];
    }

    /**
     * @author xuruiqi
     * @desc get configurations.
     */
    public function getConf()
    {
        return $this->_arrConf;
    }

    /**
     * @author xuruiqi
     * @param $key : specified field
     * @return
     *      bool  : false when field doesn't exist
     *      mixed : otherwise
     * @desc get a specified configuration.
     */
    public function getConfField($key)
    {
        if (isset($this->_arrConf[$key])) {
            return self::formatRes($this->_arrConf[$key], Error::ERR_SUCCESS);
        } else {
            return self::formatRes(null, Error::ERR_FIELD_NOT_SET);
        }
    }

    public function getContent()
    {
        return $this->_strContent;
    }

    public function getExtraInfo($arrInput)
    {
        $arrOutput = [];
        foreach ($arrInput as $req_key) {
            $arrOutput[$req_key] = $this->_arrExtraInfo[$req_key];
        }

        return $arrOutput;
    }

    public function getHyperLinks()
    {
        $arrLinks = [];
        $res = $this->sel('//a');
        for ($i = 0; $i < count($res); ++$i) {
            $arrLinks[] = $res[$i]->href;
        }

        /*
        foreach ($res as $node) {
            $arrLinks[] = $node->href;
        }
         */

        return $arrLinks;
    }

    /**
     * @author xuruiqi
     * @param
     * @return
     *      string : current page's url
     * @desc get this page's URL.
     */
    public function getUrl()
    {
        $arrRet = $this->getConfField('url');

        return strval($arrRet['res']);
    }

    /**
     * @author xuruiqi
     * @param
     *      array $conf : configurations
     *      bool  $clear_default : whether to clear default options not set in $conf
     * @return
     * @desc initialize this instance with specified or default configuration
     */
    public function init($curl_handle = null, $conf = [])
    {
        $this->_curlHandle = $curl_handle;
        if (empty($this->_curlHandle)) {
            $this->_curlHandle = curl_init();
            $this->_bolCloseCurlHandle = true;
        }
        $this->_arrConf = $this->_arrDefaultConf;

        $this->setConf($conf, true);

        return $this;
    }

    /**
     * @author xuruiqi
     * @param
     *      array $ids : elements' ids
     * @return
     *      array : array of DOMElement, with keys equal each of ids
     *      NULL  : if $this->_dom equals NULL
     * @desc select spcified elements with their ids.
     */
    /*
    public function mselId($ids) {
        if ($this->_dom === NULL) {
            Log::warning('$this->_dom is NULL!');
            return NULL;
        }

        $arrOutput = array();
        foreach ($ids as $id) {
            $arrOutput[$id] = $this->selId($id);
        }
        return $arrOutput;
    }
     */

    /**
     * @author xuruiqi
     * @param
     *      array $tags : elements' tags
     * @return
     *      array : array of DOMNodeList, with keys equal each of tags
     *      NULL  : if $this->_dom equals NULL
     * @desc select spcified elements with their tags
     */
    /*
    public function mselTagName($tags) {
        if ($this->_dom === NULL) {
            Log::warning('$this->_dom is NULL!');
            return NULL;
        }

        $arrOutput = array();
        foreach ($tags as $tag) {
            $arrOutput[$tag] = $this->selId($tag);
        }
        return $arrOutput;
    }
     */


    /**
     * @author xuruiqi
     * @param
     *      array $conf : configurations
     *      bool  $clear_previous_conf : if TRUE, then before set $conf, reset current configuration to its default value
     * @return
     *      array : previous conf
     * @desc set configurations.
     */
    public function setConf($conf = [], $clear_previous_conf = false)
    {
        $previous_conf = $this->_arrConf;
        if ($clear_previous_conf === true) {
            $this->_arrConf = $this->_arrDefaultConf;
        }
        foreach ($conf as $k => $v) {
            $this->_arrConf[$k] = $v;
        }

        $bolRes = true;
        if ($clear_previous_conf === true) {
            $bolRes = $this->_setConf($this->_arrConf);
        } else {
            $bolRes = $this->_setConf($conf);
        }

        if ($bolRes != true) {
            $this->_arrConf = $previous_conf;
            $this->_setConf($this->_arrConf);

            return $bolRes;
        }

        return $previous_conf;
    }

    protected function _setConf($conf = [])
    {
        $arrCurlOpts = [];
        foreach ($conf as $k => $v) {
            if (isset(self::$_arrField2CurlOpt[$k])) {
                $arrCurlOpts[self::$_arrField2CurlOpt[$k]] = $v;
            } else {
                //currently only curl options can be set
                $arrCurlOpts[$k] = $v;
            }
        }

        return curl_setopt_array($this->_curlHandle, $arrCurlOpts);
    }

    public function setExtraInfo($arrInput)
    {
        foreach ($arrInput as $key => $val) {
            $this->_arrExtraInfo[$key] = $val;
        }
    }

    /**
     * @author xuruiqi
     * @param
     *      string $id : specifed element id
     * @return
     *      object : DOMElement or NULL is not found
     *      NULL   : if $this->_dom equals NULL
     * @desc select a spcified element via its id.
     */
    public function selId($id)
    {
        if ($this->_dom === null) {
            Log::warning('$this->_dom is NULL!');

            return null;
        }

        return $this->_dom->getElementById($id);
    }

    /**
     * @author xuruiqi
     * @param
     *      string $tag : specifed elements' tag name
     * @return
     *      object : a traversable DOMNodeList object containing all the matched elements
     *      NULL   : if $this->_dom equals NULL
     * @desc select spcified elements via its tag name.
     */
    public function selTagName($tag)
    {
        if ($this->_dom === null) {
            Log::warning('$this->_dom is NULL!');

            return null;
        }

        return $this->_dom->getElementsByTagName($tag);
    }

    public function setConfField($field, $value)
    {
        $this->_arrConf[$field] = $value;

        return $this->_setConfField($field, $value);
    }

    protected function _setConfField($field, $value)
    {
        if (isset(self::$_arrField2CurlOpt[$field])) {
            return curl_setopt($this->_curlHandle, self::$_arrField2CurlOpt[$field], $value);
        } else {
            //currently only curl options can be set
            return curl_setopt($this->_curlHandle, $field, $value);
        }
    }

    /**
     * @author xuruiqi
     * @param
     *      string $url : the URL
     * @return
     *      string : previous URL
     * @desc set this page's URL.
     */
    public function setUrl($url)
    {
        $previous_url = $this->_arrConf['url'];
        $this->setConfField('url', $url);

        return $previous_url;
    }

    /**
     * @author  xuruiqi
     * @param
     *      array $arrHeaderList : header list
     *      e.g.
     *          array(
     *              ...
     *              "Cookie: xxxxx",
     *              ...
     *              "Header_n: header_n_value",
     *          )
     * @return
     *      this
     * @desc set header of the next fetch
     */
    public function &setHeaders($arrHeaderList)
    {
        $this->setConf(
            [
                "http_header" => $arrHeaderList,
            ]
        );

        return $this;
    }

    /**
     * @author xuruiqi
     * @param
     * @return
     *      string : return page's content
     *      bool   : if failed return FALSE
     * @desc get page's content, and save it into member variable <_strContent>
     */
    public function read()
    {
        $this->_strContent = curl_exec($this->_curlHandle);
        if ($this->_strContent != false) {
            $matches = [];
            preg_match('#charset="?([a-zA-Z0-9-\._]+)"?#', $this->_strContent, $matches);
            if (!empty($matches[1])) {
                //Log::notice("Convert content from {$matches[1]} to UTF-8\n");
                $this->_strContent = mb_convert_encoding($this->_strContent, 'UTF-8', $matches[1]);
            }

            /*
            $this->_dom = new DOMDocument(); //DOMDocument's compatibility is bad
            if (@$this->_dom->loadHTML($this->_strContent) == FALSE) {
                Log::warning('Failed to call $this->_dom->loadHTML');
                $this->_dom      = NULL;
                $this->_domxpath = NULL;
            } else {
                $this->_domxpath = new DOMXPath($this->_dom);
            }
             */

            $this->_dom = new SimpleHtmlDom();
            if (@$this->_dom->loadHTML($this->_strContent) == false) {
                Log::warning('Failed to call $this->_dom->loadHTML');
                $this->_dom = null;
            }
        }

        return $this->_strContent;
    }

    /**
     * @author xuruiqi
     * @param
     *      string $strPath : xpath's path
     *      [DOMNode $contextnode : The optional contextnode can be specified for doing relative XPath queries. By default, the queries are relative to the root element.]
     *
     * @return
     *      DOMNodelist : DOMNodelist object
     *      NULL  : if $this->_dom equals NULL
     *      false : if error occurs
     * @desc select corresponding content use xpath
     */
    public function sel($strPath, $intIndex = null, $contextnode = null)
    {
        if ($this->_dom === null) {
            Log::warning('$this->_dom is NULL!');

            return null;
        }

        if ($contextnode !== null) {
            //$res = $this->_domxpath->query($strPath, $contextnode);
            Log::warning('param contextnode is no use because of this function\'s inability');
            $res = $this->_dom->sel($strPath, $intIndex);
        } else {
            //$res = $this->_domxpath->query($strPath);
            $res = $this->_dom->sel($strPath, $intIndex);
        }

        return $res;
    }
}
