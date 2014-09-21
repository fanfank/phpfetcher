<?php
require_once(dirname(__FILE__) . '/simple_html_dom.php');

/*
 * @author xuruiqi
 * @date   2014.09.21
 * @desc   a dom implementation via simple_html_dom
 *         simple_html_dom's official site:
 *              http://sourceforge.net/projects/simplehtmldom
 */
class Phpfetcher_Dom_SimpleHtmlDom extends Phpfetcher_Dom_Abstract {
    protected $_dom = NULL;

    function __destruct() {
        if (NULL !== $this->_dom) {
            $this->_dom->clear();
        }
    }

    public function getElementById($id) {
        if (NULL === $this->_dom) {
            return FALSE;
        }
        return $this->_dom->getElementById($id);
    }

    public function getElementsByTagName($tag) {
        if (NULL === $this->_dom) {
            return FALSE;
        }
        return $this->_dom->getElementsByTagName($tag);
    }

    public function loadHTML($content) {
        if (NULL === $this->_dom) {
            $this->_dom = str_get_html($content);
        } else {
            $this->_dom->load($content);
        }

        return $this;
    }

    public function sel($pattern = '', $idx = NULL, $node = NULL) {
        if (NULL === $this->_dom) {
            return FALSE;
        }
        return $this->_dom->find($pattern, $idx);
    }

}
