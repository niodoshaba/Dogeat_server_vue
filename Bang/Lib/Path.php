<?php

namespace Bang\Lib;

/**
 * 處理檔案位置功能
 * @author Bang
 */
class Path {

    /**
     * 回傳網站Model檔案
     * EX:(User) return /Models/User.php
     * @return string Model檔案網址
     */
    public static function Model($name) {
        $modelFile = Path::Content("Models/$name.php");
        return $modelFile;
    }

    /**
     * 回傳網站Root起算相對網址
     * EX:(Views/Home/Index.php) return /Views/Home/Index.php
     * @param string $url
     * @return string
     */
    public static function Content($url) {
        if (!eString::StartsWith($url, "/")) {
            $url = "/$url";
        }
        if (DIRECTORY_SEPARATOR == "\\") {
            $url = str_replace("/", "\\", $url);
        }
        $root = \Config::$Path;
        return $root . $url;
    }

    /**
     * 回傳網站View檔案
     * EX:(Index.php) return /Views/{ControllerName}/Index.php Or  /Views/Shared/Index.php
     * @param string $url
     * @return string View檔案網址
     */
    public static function View($name, $className = "") {
        $viewFile = Path::Content("Views/$className/$name.php");
        return $viewFile;
    }

    /**
     * 回傳網站Share View檔案
     * EX:(Index.php) /Views/Shared/Index.php
     * @param string $name
     * @return string View檔案網址
     */
    public static function ShareView($name) {
        $viewFile = Path::Content("Views/Shared/{$name}.php");
        return $viewFile;
    }

}
