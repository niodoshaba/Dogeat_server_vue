<?php

namespace Bang\Lib;

/**
 * ORM常用功能
 * @author Bang
 */
class ORM {

    /**
     * 將物件轉換為陣列
     * @param mixed $obj
     * @return array 結果陣列
     */
    public static function ObjectToArray($obj, $unset_if_null = false) {
        $array = get_object_vars($obj);
        if ($unset_if_null) {
            $result = array();
            foreach ($array as $key => $value) {
                if (!is_null($array[$key])) {
                    $result[$key] = $value;
                }
            }
        } else {
            $result = $array;
        }
        return $result;
    }

    /**
     * 取得物件各属性名称
     * @param mixed $objOrClassName
     * @return array
     */
    public static function GetPropertiesName($objOrClassName) {
        $reflect = new \ReflectionClass($objOrClassName);
        $obj = $objOrClassName;
        if (!is_a($obj, $reflect->getName())) {
            $obj = $reflect->newInstanceArgs();
        }
        $properties = $reflect->getProperties();
        $result = array();
        foreach ($properties as $property) {
            $result[] = $property->name;
        }
        return $result;
    }

    /**
     * 將Array(字串索引)轉換為物建
     * @param array $array 字串索引的陣列
     * @param string $objOrClassName 物件或物件類別名稱
     * @return mixed 轉換結果
     */
    public static function ArrayToObject($array, $objOrClassName) {
        $reflect = new \ReflectionClass($objOrClassName);
        $obj = $objOrClassName;
        if (!is_a($obj, $reflect->getName())) {
            $obj = $reflect->newInstanceArgs();
        }

        $properties = $reflect->getProperties();
        foreach ($properties as $property) {
            $name = $property->name;
            if (isset($array[$name])) {
                $property->setValue($obj, $array[$name]);
            }
        }
        return $obj;
    }

    public static function CopyPropertiesIfExist($src_obj, $target_obj, $space_to_null = false) {
        $reflect = new \ReflectionClass($target_obj);
        $array = self::ObjectToArray($src_obj);

        $properties = $reflect->getProperties();
        foreach ($properties as $property) {
            $name = $property->name;

            if (isset($array[$name])) {
                if ($space_to_null && eString::IsNullOrSpace($array[$name])) {
                    $property->setValue($target_obj, NULL);
                } else {
                    $property->setValue($target_obj, $array[$name]);
                }
            }
        }
        return $target_obj;
    }

    /**
     * 將2維 陣列(第二維必須維字串索引)  轉換為物件陣列 並對應Key名稱
     * @param array $array 2維陣列 字串索引的陣列
     * @param string $className 物建類別名稱
     * @return array 轉換結果陣列
     */
    public static function TwoDArrayToObjectsKeyArray($twoD_Array, $className, $key_name) {
        $reflect = new \ReflectionClass($className);
        $result = array();

        foreach ($twoD_Array as $row) {
            $item = $reflect->newInstanceArgs();
            //設定所有屬性
            $properties = $reflect->getProperties();
            foreach ($properties as $property) {
                $name = $property->name;
                if (isset($row[$name])) {
                    $property->setValue($item, $row[$name]);
                }
            }
            $key = $row[$key_name];
            $result[$key] = $item;
        }
        return $result;
    }

    /**
     * 將2維 陣列(第二維必須維字串索引)  轉換為物件陣列
     * @param array $twoD_Array 2維陣列 字串索引的陣列
     * @param string $className 物建類別名稱
     * @return array 轉換結果陣列
     */
    public static function TwoDArrayToObjects($twoD_Array, $className) {
        $reflect = new \ReflectionClass($className);
        $result = array();

        foreach ($twoD_Array as $row) {
            $item = $reflect->newInstanceArgs();

            //設定所有屬性
            $properties = $reflect->getProperties();
            foreach ($properties as $property) {
                $name = $property->name;
                if (isset($row[$name])) {
                    $property->setValue($item, $row[$name]);
                }
            }
            $result[] = $item;
        }
        return $result;
    }

}
