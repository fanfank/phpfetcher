<?php

namespace Phpfetcher\Dom;

use Phpfetcher\Log;

/**
 * @author xuruiqi
 * @date   2014.09.21
 * @copyright reetsee.com
 * @desc   a dom implementation via simple_html_dom
 *         simple_html_dom's official site:
 *              http://sourceforge.net/projects/simplehtmldom
 */

class SimpleHtmlDom extends AbstractDom
{
    /**
     * @var $_dom \simple_html_dom
     */
    protected $_dom = null;

    public function __destruct()
    {
        if (method_exists($this->_dom, 'clear')) {
            $this->_dom->clear();
        }
    }

    public function getElementById($id)
    {
        $strMethodName = 'getElementById';
        if (method_exists($this->_dom, $strMethodName)) {
            return $this->_dom->getElementById($id);
        } else {
            Log::warning("method $strMethodName not exists");

            return false;
        }
    }

    public function getElementsByTagName($tag)
    {
        $strMethodName = 'getElementsByTagName';
        if (method_exists($this->_dom, $strMethodName)) {
            return $this->_dom->getElementsByTagName($tag);
        } else {
            Log::warning("method $strMethodName not exists");

            return false;
        }
    }

    public function loadHTML($content)
    {
        if (null === $this->_dom) {
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
    public function sel($pattern = '', $idx = null, $node = null)
    {
        return $this->find($pattern, $idx);
    }

    public function find($pattern = '', $idx = null)
    {
        $strMethodName = 'find';
        if (method_exists($this->_dom, $strMethodName)) {
            return $this->_dom->find($pattern, $idx);
        } else {
            Log::warning("method $strMethodName not exists");

            return false;
        }
    }
}
