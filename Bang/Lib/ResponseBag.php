<?php

namespace Bang\Lib;

/**
 * 存放本次回傳Response的各參數
 * 存放內容將會在回傳後清除(目前以$_REQUEST實作)
 * @author Bang
 */
class ResponseBag {

    /**
     * 將一個物件加入store中
     * @param string $name 物件名稱(索引,為空時將直接使用該物件類別名稱)
     * @param mixed $obj 要儲存的物件
     * @return obj 若已有舊的物件將會回傳舊的
     */
    public static function Add($name, $obj) {
        $name = strtolower($name);

        $return = null;
        if (isset($_REQUEST[$name])) {
            //已經有舊的物件時,將舊的物件回傳
            $return = $_REQUEST[$name];
        }

        $_REQUEST[$name] = $obj;
        return $return;
    }

    /**
     * 從註冊表中取得物件
     * @param string $name 物件名稱,{@see self::set()}
     * @return mixed 物件
     */
    public static function Get($name) {
        $name = strtolower($name);

        if (!self::Contains($name)) {
            return "";
        }
        return $_REQUEST[$name];
    }

    /**
     * 檢查是否有物件物件存在
     * @param type $name 物件名稱
     * @return boolean 檢查結果
     */
    public static function Contains($name) {
        $name = strtolower($name);

        if (!isset($_REQUEST[$name])) {
            return false;
        }
        return true;
    }

    /**
     * 從註冊中刪除物件
     * @param string $name 物件名稱
     * @return void
     */
    public static function Remove($name) {
        $name = strtolower($name);
        if (self::contains($name)) {
            unset($_REQUEST[$name]);
        }
    }

}
