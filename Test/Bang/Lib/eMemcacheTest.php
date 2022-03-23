<?php

use Bang\Lib\eMemcache;

require_once 'auto_load.php';
require_once 'Bang/TestModels/ForTestAppstore.php';

class eMemcacheTest extends PHPUnit_Framework_TestCase {

    protected function setUp() {
        
    }

    /**
     * @return ForTestAppstore
     */
    private function GetData() {
        if (ConfigMemecache::Enable) {
            $result = new ForTestAppstore();
            $result->name = "Name" . rand(100, 999);
            $result->password = "Password" . rand(100, 999);
            $result->roles = "Roles" . rand(100, 999);
            return $result;
        }
    }

    public function testSetAndGet() {
        if (ConfigMemecache::Enable) {
            $data = $this->GetData();
            $key = $data->name;
            eMemcache::Set($key, $data);
            $data2 = eMemcache::Get($key);
            $this->assertTrue($data->Equal($data2));
        }
    }

    public function testSetAndTimeoutAndGet() {
        if (ConfigMemecache::Enable) {
            $data = $this->GetData();
            $key = $data->name;
            eMemcache::Set($key, $data, 1);
            sleep(2);
            $this->assertFalse(eMemcache::ContainKey($key));
        }
    }

    public function testSetAndDeleteAndGet() {
        if (ConfigMemecache::Enable) {
            $data = $this->GetData();
            $key = $data->name;
            eMemcache::Set($key, $data, 1);
            $data2 = eMemcache::Get($key);
            $this->assertTrue($data->Equal($data2));

            eMemcache::Delete($key);
            $this->assertFalse(eMemcache::ContainKey($key));
        }
    }

    public function testSetAndInTimeoutGet() {
        if (ConfigMemecache::Enable) {
            $data = $this->GetData();
            $key = $data->name;
            eMemcache::Set($key, $data, 2);
            sleep(1);
            $this->assertTrue(eMemcache::ContainKey($key));
        }
    }

}
