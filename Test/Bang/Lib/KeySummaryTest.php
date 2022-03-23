<?php

require_once 'auto_load.php';

class Test1 {

    public $item1;
    public $item2;

}

class KeySummaryTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {
        
    }

    public function testBasicFunction() {
        $obj = new Bang\Lib\KeySummary();
        $obj->Add('test1', 10);
        $obj->Add('test1', 10);
        $obj->Add('test1', 10);
        $obj->Add('test1', 25);

        $this->assertEquals($obj->Get('test1'), 55);
    }

}
