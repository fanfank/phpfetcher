<?php
namespace xiaogouxo\phpfetcher\Page;
/*
 * @author xuruiqi
 * @date   2014.06.28
 * @copyright reetsee.com
 * @abstract Page's abstract class
 */

abstract class Page {

    protected $_strContent = NULL;

    public function __construct() {

    }

    public function __destruct() {

    }

    public function __get($key) {
        echo $key, 'doesn\'t exist!';
    }

    public function __set($key, $val) {
        echo "Can't assign '$val' to $key!";
    }

    /**
     * @abstract get configurations.
     */
    abstract function getConf();
    //{
        //echo 'Not implemented';
    //}

    /**
     * @abstract get page's URL.
     */
    abstract function getUrl();

    /**
     * @abstract initialize this instance with specified or default configuration
     */
    abstract function init();

    /**
     * @abstract get page's content, and save it into member variable $content
     */
    abstract function read();

    /**
     * @abstract set configurations.
     */
    abstract function setConf($conf = array());
    //{
        //echo 'Not implemented';
    //}

    /**
     * @abstract set page's URL.
     */
    abstract function setUrl($url);

    //取出$_strContent中的所有<a>标签的内容，以数组形式返回
    abstract function getHyperLinks();
}
?>
