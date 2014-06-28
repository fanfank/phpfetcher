<?php
/*
 * @author xuruiqi
 * @date   2014.06.28
 * @abstract Default Page class
 */
class Phpfetcher_Page_Default extends Phpfetcher_Page_Abstract {
    //TODO
    private $_arrDefaultConf = array(
        
    );

    protected $_arrConf = array();

    public __construct() {}
    public __destruct() {}

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
