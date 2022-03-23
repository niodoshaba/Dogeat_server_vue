<?php

use Bang\Tools\ObjectSyntaxGenerator;

require_once 'auto_load.php';

/**
 * @author Bang
 */
class ObjectSyntaxGeneratorTest extends PHPUnit_Framework_TestCase {

    public function testConnectMarkToPascalNaming() {
        $name = "bang_test_logs";
        $result = ObjectSyntaxGenerator::ConnectMarkToPascalNaming($name);
        $this->assertEquals($result, 'BangTestLogs');
    }

}
