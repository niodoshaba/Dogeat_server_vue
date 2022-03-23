<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ForTestAppstore
 *
 * @author Bang
 */
class ForTestAppstore {

    public $name;
    public $password;
    public $roles;

    public function Equal(ForTestAppstore $obj) {
        return ($this->name == $obj->name) && ($this->password == $obj->password) && ($this->roles == $obj->roles);
    }

}
