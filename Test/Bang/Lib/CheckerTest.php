<?php

require_once 'auto_load.php';

use Bang\Lib\Checker;

/**
 * 字串功能測試
 */
class CheckerTest extends PHPUnit_Framework_TestCase {

    public function testIsEmail() {
        //Arrange 
        $email = 'bangtest@gmail.com';

        //Act
        $result = Checker::IsEmail($email);

        //Assert
        $this->assertTrue($result);
    }

    public function testIsDate(){
        $date = '2017-07-12' ;
        $result = Checker::IsDate($date);
        $this->assertTrue($result);
    }
    
    public function testIsDate_not(){
        $date = '2017-07-121' ;
        $result = Checker::IsDate($date);
        $this->assertFalse($result);
    }
    
    public function testIPv4() {
        $ip = "127.0.0.1"; //ipv4
        $result = Checker::IP($ip);
        $this->assertTrue($result);
    }

    public function testIPv6() {
        $ip = "2001:0db8:85a3:08d3:1319:8a2e:0370:7334"; //ipv6
        $result = Checker::IP($ip);
        $this->assertTrue($result);
    }

    public function testUrl() {
        $url = "http://example.com";
        $result = Checker::Url($url);
        $this->assertTrue($result);
    }
    
    public function testUrlWithSsl() {
        $url = "https://example.com/test-check/";
        $result = Checker::Url($url);
        $this->assertTrue($result);
    }

    public function testRegexpFalse() {
        $input = "123";
        $regexp = "/[\&]/";
        $result = Checker::Regexp($input, $regexp);
        $this->assertFalse($result);
    }

    public function testRegexpTrue() {
        $input = "12&3";
        $regexp = "/[\&]/";
        $result = Checker::Regexp($input, $regexp);
        $this->assertTrue($result);
    }

    
    public function testWord() {
        $input = "1est1225";
        $length_max = "15";
        $length_min = "5";
        $result = Checker::Word($input, $length_max, $length_min);
        $this->assertTrue($result);
    }

    public function testMatch() {
        $input = "test1225\\";
        $characters = "*,^,\\";
        $result = Checker::Match($input, $characters);
        $this->assertTrue($result);
    }

}
