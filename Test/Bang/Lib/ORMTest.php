<?php

require_once 'auto_load.php';

class TestORM1 {

    public $item1;
    public $item2;

}

class ORMTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {
        
    }

    public function testGetPropertiesName() {
        // Arrange
        $results = \Bang\Lib\ORM::GetPropertiesName('TestORM1');

        $this->assertEquals($results[0], 'item1');
        $this->assertEquals($results[1], 'item2');
        $this->assertFalse(isset($results[2]));
    }

}
