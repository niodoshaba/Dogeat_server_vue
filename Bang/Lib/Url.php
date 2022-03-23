<?php

namespace Bang\Lib;

use Bang\MVC\Route;

/**
 * 處理網址擴充功能
 * @author Bang
 */
class Url {

    /**
     * 回傳網站Root起算相對網址
     * EX:(Views/Home/Index.php) return /Views/Home/Index.php
     * @param string $url
     * @return string
     */
    public static function Content($url) {
        return \Config::$Root . $url;
    }

    /**
     * 回传图片网址（以/Content/img/ 开头）
     * @param type $url
     * @return type
     */
    public static function Img($url) {
        return self::Content("Content/img/{$url}");
    }

    /**
     * 回傳網站View檔案
     * EX:(Index.php) return /Views/{ControllerName}/Index.php Or  /Views/Shared/Index.php
     * @param string $url
     * @return string View檔案網址
     */
    public static function View($name, $className = "") {
        $root = \Config::$Root;
        $viewFile = "{$root}Views/$className/$name.php";
        return $viewFile;
    }

    /**
     * 回傳網站Share View檔案
     * EX:(Index.php) /Views/Shared/Index.php
     * @param string $name
     * @return string View檔案網址
     */
    public static function ShareView($name) {
        $root = \Config::$Root;
        $viewFile = "{$root}Views/Shared/{$name}.php";
        return $viewFile;
    }

    /**
     * 取得Action網址
     * @param string $action Action名稱
     * @param string $controller Controller名稱
     * @param mixed $params 其他參數
     * @return string Action網址
     */
    public static function Action($action, $controller = "", $params = null) {
        if (eString::IsNullOrSpace($controller)) {
            $controller = Route::Current()->controller;
        }
        if (is_null($params)) {
            $params = array();
        }
        if (!is_array($params)) {
            $params = get_object_vars($params);
        }
        $params['action'] = $action;
        $params['controller'] = $controller;
        $query_string = http_build_query($params);
        $root = \Config::$Root;
        $resultUrl = "{$root}index.php?{$query_string}";
        return $resultUrl;
    }

    public static function Relative() {
        return $_SERVER['REQUEST_URI'];
    }

}
