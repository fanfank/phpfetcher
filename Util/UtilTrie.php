<?php
namespace xiaogouxo\phpfetcher\Util;

use xiaogouxo\phpfetcher\Log;
/*
 * @author xuruiqi
 * @date 2015-10-26
 * @copyright reetsee.com
 * @desc 字典树的简单实现，没有做内存优化
 *       A simple implementation of trie without improvements on memory
 */

class UtilTrie {
    protected $_arrTrieRoot = array();

    public function __construct($arrStrings = array()) {
        $this->_arrTrieRoot = array(
            'children' => array(),       
            'count'    => 0,
        );
        foreach ($arrStrings as $str) {
            $this->insert($str);
        }
    }

    public function insert($str) {
        try {
            $str        = strval($str);
            $intLen     = strlen($str);
            $arrCurNode = &$this->_arrTrieRoot;

            for ($i = 0; $i < $intLen; ++$i) {
                if (!isset($arrCurNode['children'][$str[$i]])) {
                    $arrCurNode['children'][$str[$i]] = array(
                        'children' => array(),
                        'count'    => 0,
                    );
                }
                $arrCurNode = &$arrCurNode['children'][$str[$i]];
            }

            $arrCurNode['count'] += 1;
            unset($arrCurNode);

        } catch (\Exception $e) {
            Log::fatal($e->getMessage());
            return false;
        }

        return true;
    }

    public function delete($str) {
        $arrCurNode = &$this->_locateNode($str);
        if (!is_null($arrCurNode) && $arrCurNode['count'] > 0) {
            $arrCurNode['count'] -= 1;
        }
        unset($arrCurNode);
        return true;
    }

    public function has($str) {
        $arrTargetNode = &$this->_locateNode($str);
        $bolRes = false;
        if (!is_null($arrTargetNode) && $arrTargetNode['count'] > 0) {
            $bolRes = true;
        }
        unset($arrTargetNode);
        return $bolRes;
    }

    protected function &_locateNode($str) {
        $str = strval($str);
        $intLen     = strlen($str);
        $arrCurNode = &$this->_arrTrieRoot;

        for ($i = 0; $i < $intLen; ++$i) {
            if (!isset($arrCurNode['children'][$str[$i]])) {
                return null;
            }
            $arrCurNode = &$arrCurNode['children'][$str[$i]];
        }

        return $arrCurNode;
    }

    //public function startsWith($str) {
    //    $str = strval($str);
    //    //TODO
    //}
};
