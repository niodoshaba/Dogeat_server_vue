<?php

namespace Bang\Lib;

/*
 * 主要在於協助取得回傳Resposne
 * 以物件方式處理
 */

/**
 * Response 擴充功能
 * @author Bang
 */
class Response {

    public static function NoAcceptable($msg = 'Not Acceptable') {
        Response::HttpError(406, $msg);
    }

    public static function Forbidden($msg = 'Forbidden') {
        Response::HttpError(403, $msg);
    }

    public static function HttpUnauthorized($msg = 'Unauthorized') {
        Response::HttpError(401, $msg);
    }

    /**
     * 回傳找不到網頁
     * @param string $msg 檢視訊息
     */
    public static function HttpNotFound($msg = 'Not Found') {
        Response::HttpError(404, $msg);
    }

    public static function HttpError($code, $msg) {
        header("HTTP/1.0 {$code} {$msg}");
        echo $msg;
        die();
    }

    /**
     * 重新導向網址
     * @param string $url 導向的網址
     */
    public static function RedirectUrl($url) {
        header("Location: {$url}");
        die();
    }

}
