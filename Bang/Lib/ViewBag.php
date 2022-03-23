<?php

namespace Bang\Lib;

/**
 * 存放本次回傳View專用包
 * 存放內容將會在回傳後清除(目前以$_REQUEST實作)
 * @author Bang
 */
class ViewBag {

    public function __construct() {
        $this->Title = "";
        $this->Description = "";
    }

    /**
     * @var string 標題
     */
    public $Title;

    /**
     * @var string 網頁描述(SEO)
     */
    public $Description;

    /**
     * 設定一般常用的ViewBag值
     * @param string $title 標題前置
     * @param string $description 網頁敘述
     */
    public static function SetNormalSite($title, $description = '') {
        $current = ViewBag::Get();
        $current->Title = $title;
        $current->Description = $description;
        $current->Write();
    }

    /**
     * 將ViewBag寫入ResponseBag中
     */
    public function Write() {
        ResponseBag::Add(ViewBag::ResponseBagName, $this);
    }

    /**
     * 取得當前ViewBag(為空實自動產生)
     * @return ViewBag 當前ViewBag
     */
    public static function Get() {
        if (!ResponseBag::Contains(ViewBag::ResponseBagName)) {
            ResponseBag::Add(ViewBag::ResponseBagName, new ViewBag());
        }
        return ResponseBag::Get(ViewBag::ResponseBagName);
    }

    /**
     * 取得標題(固定模式)
     * @return string 標題結果
     */
    public static function GetTitle() {
        $current = ViewBag::Get();

        if (eString::IsNotNullOrSpace($current->Title)) {
            return $current->Title . " - " . \Config::$SiteName;
        } else {
            return \Config::$SiteName;
        }
    }

    /**
     * ResponseBag固定存放名稱
     */
    const ResponseBagName = "__ViewBag";

}
