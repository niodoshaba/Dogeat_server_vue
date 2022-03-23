<?php

namespace Bang\Lib;

/**
 * 注册表物件（访Memcache）
 * @author Bang
 */
class Registry {

    function __construct() {
        $this->_current = array();
    }

    private $_current;

    public function contains($name) {
        return isset($this->_current[$name]);
    }

    public function get($name) {
        if ($this->contains($name)) {
            return $this->_current[$name];
        } else {
            return false;
        }
    }

    public function set($name, $value) {
        $this->_current[$name] = $value;
    }

    public function delete($name) {
        unset($this->_current[$name]);
    }

}
