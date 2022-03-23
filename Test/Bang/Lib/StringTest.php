<?php

require_once 'auto_load.php';

use Bang\Lib\eString;

/**
 * 字串功能測試
 */
class StringTest extends PHPUnit_Framework_TestCase {

    public function tests() {
        $test = 'banG';

        $result = eString::ToFirstCharUpperFormat($test);
        $this->assertEquals($result, 'Bang');
    }

    public function testIsNullOrSpace() {
        //Arrange 
        $strTrue = '  ';
        $strFalse = " g";
        $strTrue2 = NULL;

        //Act
        $resultTrue1 = eString::IsNullOrSpace($strTrue);
        $resultFalse1 = eString::IsNullOrSpace($strFalse);
        $resultTrue2 = eString::IsNullOrSpace($strTrue2);
        $resultTrue3 = eString::IsNullOrSpace("");

        //Assert
        $this->assertEquals($resultTrue1, TRUE);
        $this->assertEquals($resultFalse1, FALSE);
        $this->assertEquals($resultTrue2, TRUE);
        $this->assertEquals($resultTrue3, TRUE);
    }

    public function testRemoveSuffix() {
        // Arrange
        $suffix = 'Controller';
        $str1 = 'HomeController';
        $str2 = 'Home2Controller';
        $str3 = 'SiteController';

        // Act
        $result1 = eString::RemoveSuffix($str1, $suffix);
        $result2 = eString::RemoveSuffix($str2, $suffix);
        $result3 = eString::RemoveSuffix($str3, $suffix);

        // Assert
        $this->assertEquals($result1, "Home");
        $this->assertEquals($result2, "Home2");
        $this->assertEquals($result3, "Site");
    }

    public function testRemovePrefix() {
        // Arrange
        $prefix = 'bla_';
        $str = 'bla_string_bla_bla_bla';

        // Act
        $result = eString::RemovePrefix($str, $prefix);

        // Assert
        $this->assertEquals($result, "string_bla_bla_bla");
    }

    public function testStartsWith() {
        // Arrange
        $test = "test1";
        $test2 = "";

        // Act
        $isTrue = eString::StartsWith($test, "test");
        $isFlase = eString::StartsWith($test, "1");
        $isFalse2 = eString::StartsWith($test2, "1");

        // Assert
        $this->assertTrue($isTrue);
        $this->assertFalse($isFlase);
        $this->assertFalse($isFalse2);
    }

    public function testEndsWith() {
        // Arrange
        $test = "test1";
        $test2 = "";

        // Act
        $isFlase = eString::EndsWith($test, "test");
        $isTrue = eString::EndsWith($test, "1");
        $isFalse2 = eString::EndsWith($test2, "1");

        // Assert
        $this->assertTrue($isTrue);
        $this->assertFalse($isFlase);
        $this->assertFalse($isFalse2);
    }

}
