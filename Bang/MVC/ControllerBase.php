<?php

namespace Bang\MVC;

use Bang\Lib;
use Bang\Lib\Response;
use Bang\Lib\Url;

/**
 * 所有Controller的基底
 * @author Bang
 */
class ControllerBase {

    /**
     * 回傳View結果
     * 帶預設Layout.php
     */
    protected function View($viewName = "", $layout = "_Layout") {
        if (Lib\eString::IsNullOrSpace($viewName)) {
            $viewName = Route::Current()->action;
        }
        $className = Lib\eString::RemovePrefix(get_class($this), "Controllers\\");
        $viewFile = "{$className}/{$viewName}.php";
        Lib\ResponseBag::Add("View", $viewFile);
        $layoutFile = Lib\Path::View($layout, "Shared");
        include $layoutFile;
    }

    /**
     * 回傳Json格式結果
     * @param object $obj 傳入物件，為空時將自動傳TaskResult並IsSuccess為true
     */
    protected function Json($obj = NULL) {
        if ($obj === NULL) {
            $obj = new Lib\TaskResult();
            $obj->IsSuccess = true;
        }
        $result = json_encode($obj, JSON_UNESCAPED_UNICODE);
        return $this->JsonContent($result);
    }

    /**
     * 以 Json 字串回傳json格式
     * @param string $json_str 傳入JSON格式字串，為空時將自動傳TaskResult並IsSuccess為true
     */
    protected function JsonContent($json_str) {
        header('Content-Type: application/json');
        echo $json_str;
    }

    /**
     * 重新導向網址
     * @param string $url 導向的網址
     */
    protected function RedirectToUrl($url) {
        Response::RedirectUrl($url);
        die();
    }

    /**
     * 重新導向網址
     * @param string $url 導向的網址
     */
    protected function RedirectToAction($actoiName, $controller = null, $params = array()) {
        if (null == $controller) {
            $controller = Route::Current()->controller;
        }
        $url = Url::Action($actoiName, $controller, $params);
        $this->RedirectToUrl($url);
    }

}
