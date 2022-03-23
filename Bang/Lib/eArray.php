<?php

namespace Bang\Lib;

/**
 * @author Bang
 */
class eArray {

    public static function SelectColumn(array $input, $columnKey, $indexKey = null) {
        if (function_exists('array_column')) {
            return array_column($input, $columnKey, $indexKey);
        } else {
            $array = array();
            foreach ($input as $value) {
                if (!isset($value[$columnKey])) {
                    trigger_error("Key \"$columnKey\" does not exist in array");
                    return false;
                }
                if (is_null($indexKey)) {
                    $array[] = $value[$columnKey];
                } else {
                    if (!isset($value[$indexKey])) {
                        trigger_error("Key \"$indexKey\" does not exist in array");
                        return false;
                    }
                    if (!is_scalar($value[$indexKey])) {
                        trigger_error("Key \"$indexKey\" does not contain scalar value");
                        return false;
                    }
                    $array[$value[$indexKey]] = $value[$columnKey];
                }
            }
            return $array;
        }
    }

}
