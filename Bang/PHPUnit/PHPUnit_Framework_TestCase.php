<?php

/**
 * 用于对应已有的功能而非真的会执行
 * @author Bang
 */
class PHPUnit_Framework_TestCase {

    /**
     * 断言Array中是否有Key
     * @param string $key
     * @param array $array
     * @param string $message 错误讯息
     */
    protected function assertArrayHasKey($key, $array, $message = '') {
        
    }

    /**
     * 断言Class中含有某属性值
     * @param type $attribute_name
     * @param type $class_name
     * @param string $message 错误讯息
     */
    protected function assertClassHasAttribute($attribute_name, $class_name, $message = '') {
        
    }

    /**
     * 断言needle存在于haystack中
     * @param mixed $needle
     * @param Iterator|array $haystack
     * @param string $message
     */
    protected function assertContains($needle, $haystack, $message = '') {
        
    }

    /**
     * 断言needle不存在于haystack中
     * @param mixed $needle
     * @param Iterator|array $haystack
     * @param string $message
     */
    protected function assertNotContains($needle, $haystack, $message = '') {
        
    }

    /**
     * 验证两数值是否相等
     * @param mixed $value1
     * @param mixed $value2
     * @param string $message
     */
    protected function assertEquals($value1, $value2, $message = '') {
        
    }

    /**
     * 验证是否为False
     * @param mixed $value
     * @param string $message
     */
    protected function assertFalse($value, $message = '') {
        
    }

    /**
     * 验证是否为True
     * @param mixed $value
     * @param string $message
     */
    protected function assertTrue($value, $message = '') {
        
    }

}
