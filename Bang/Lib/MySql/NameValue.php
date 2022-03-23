<?php

namespace Bang\Lib\MySql;

/**
 * @author Bang
 */
class NameValue {

    function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    public $name;
    public $value;

}
