<?php

namespace Bang\Lib;

/**
 * @author Bang
 */
class KeySummary {

    function __construct() {
        $this->datas = array();
    }

    private $datas;

    private function Init($key) {
        if (!isset($this->datas[$key])) {
            $this->datas[$key] = 0;
        }
    }

    public function Add($key, $value) {
        $this->Init($key);
        $this->datas[$key] += $value;
    }

    public function Get($key) {
        $this->Init($key);
        $result = $this->datas[$key];
        return $result;
    }

}
