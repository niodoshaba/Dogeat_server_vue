<?php

namespace Bang\Lib;

/*
 * 主要在於協助取得使用者Request來的資料
 * 以物件方式取得
 */

/**
 * Request擴充功能
 * @author Bang
 */
class Request {

    public static function GetIpAddress() {
        $vars = array(
            1 => 'HTTP_X_FORWARDED_FOR',
            2 => 'HTTP_INCAP_CLIENT_IP',
            3 => 'HTTP_CF_CONNECTING_IP',
            4 => 'REMOTE_ADDR'
        );
        foreach ($vars as $key => $value) {
            if (isset($_SERVER[$value])) {
                $ip_array = eString::Split($_SERVER[$value], ",");
                return $ip_array[0];
            }
        }
    }

    /**
     * 取得使用者的請求資料
     * @param mixed $obj 傳入取值物件
     * @param boolean $isPost 是否為Post方式傳遞
     */
    public static function GetParam($obj, $isPost = false) {
        $from = ($isPost ? $_POST : $_GET);
        return ORM::ArrayToObject($from, $obj);
    }

    /**
     * 取得Post資料 EX:getPost($result = new NewClasss())將取得回傳的NewClass
     * @param type $obj 傳入對應Class的物件
     */
    public static function GetPost($obj) {
        return Request::GetParam($obj, true);
    }

    /**
     * 取得Get資料 EX:getGet($result = new NewClasss())將取得回傳的NewClass
     * @param type $obj 傳入對應Class的物件
     */
    public static function GetGet($obj) {
        return Request::GetParam($obj, false);
    }

    public static function GetRequest($obj) {
        $from = $_REQUEST;
        return ORM::ArrayToObject($from, $obj);
    }

    /**
     * 取得相對位置網址
     * @return string 對應相對網址
     */
    public static function GetPathAndQuery() {
        return $_SERVER['REQUEST_URI'];
    }

    public static function GetPostBody() {
        return file_get_contents('php://input');
    }

}
