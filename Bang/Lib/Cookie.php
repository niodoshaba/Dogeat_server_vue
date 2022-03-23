<?php

namespace Bang\Lib;

/**
 * Cookie 專用套件
 * @author Bang
 */
class Cookie {

    /**
     * 是否有Cookie值
     * @param string $name Cookie名稱
     * @return boolean 判斷結果
     */
    public static function HasCookie($name) {
        return isset($_COOKIE[$name]);
    }

    /**
     * 設定Cookie值
     * @param string $name Cookie名稱
     * @param string $value Cookie值
     * @param int $expires 保留天數
     * @param string $path 針對站內子目錄應用位置
     */
    public static function SetCookie($name, $value, $expires = 30, $path = '/') {
        setcookie($name, $value, time() + (60 * 60 * 24 * $expires), $path);
    }

    /**
     * 取得Cookie值
     * @param string $name Cookie 名稱
     * @return string Cookie 值
     */
    public static function GetCookie($name) {
        if (Cookie::HasCookie($name)) {
            return $_COOKIE[$name];
        } else {
            return null;
        }
    }

    public static function RemoveCookie($name) {
        if (Cookie::HasCookie($name)) {
            setcookie($name, null, -1);
        }
    }

}
