<?php

namespace Bang\Structs;

/**
 * @author Bang
 */
class ServerLoginData {

    function __construct($host = null, $username = null, $password = null) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    public $host;
    public $username;
    public $password;

}
