<?php
require_once(dirname(__FILE__) . '/simple_html_dom.php');

/*
 * @author xuruiqi
 * @date   2014.09.21
 * @copyright reetsee.com
 * @desc   a dom implementation via simple_html_dom
 *         simple_html_dom's official site:
 *              http://sourceforge.net/projects/simplehtmldom
 */
class Phpfetcher_Dom_SimpleHtmlDom extends Phpfetcher_Dom_Abstract {
    protected $_dom = NULL;

    function __destruct() {
        if (method_exists($this->_dom, 'clear')) {
            $this->_dom->clear();
        }
    }

    public function getElementById($id) {
        $strMethodName = 'getElementById';
        if (method_exists($this->_dom, $strMethodName)) {
            return $this->_dom->getElementById($id);
        } else {
            Phpfetcher_Log::warning("method $strMethodName not exists");
            return FALSE;
        }
    }

    public function getElementsByTagName($tag) {
        $strMethodName = 'getElementsByTagName';
        if (method_exists($this->_dom, $strMethodName)) {
            return $this->_dom->getElementsByTagName($tag);
        } else {
            Phpfetcher_Log::warning("method $strMethodName not exists");
            return FALSE;
        }
    }

    public function loadHTML($content) {
        if (NULL === $this->_dom) {
            if (function_exists('str_get_html')) {
                $this->_dom = str_get_html($content);
            }
        } else {
            if (method_exists($this->_dom, 'load')) {
                $this->_dom->load($content);
            }
        }

        return $this;
    }

    /**
     * @deprecated
     */
    public function sel($pattern = '', $idx = NULL, $node = NULL) {
        return $this->find($pattern, $idx);
    }

    public function find($pattern = '', $idx = NULL) {
        $strMethodName = 'find';
        if (method_exists($this->_dom, $strMethodName)) {
            return $this->_dom->find($pattern, $idx);
        } else {
            Phpfetcher_Log::warning("method $strMethodName not exists");
            return FALSE;
        }
    }
}
