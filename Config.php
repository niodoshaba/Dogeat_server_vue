<?php

class Config {

   /**
     * @var string 網站跟目錄（相對位置）
     */
    public static $Root = "";
    public static $Path = __DIR__;

    /**
     * @var string 網站名稱(會出現在Title 後至)
     */
    public static $SiteName = "Dog吃菜後台";

    //資料庫各項連線設定
    // const DbName = "dogeatveg";
    // const DbHost = "localhost";
    // const DbPort = "81";
    // const DbUser = "root";
    // const DbPassword = "Mysql1234@";
    // const EnablePHPErrorReport = true;
    const DbName = "b17_31353834_dogeat_php";
    const DbHost = "sql301.byethost17.com";
    const DbUser = "b17_31353834";
    const DbPassword = "kenken664";
    const EnablePHPErrorReport = true;
}

class ConfigMemecache {

    const Enable = false;
    const Host = "localhost";
    const Port = 11211;

}

class ApiConfig {

    const LogType = ApiLogTypes::Daily;
    const LogError = true;
    const LogResponse = false;
    const LogRequest = false;
    const LoadingRecords = true;
    const Key = 'bang_api_test';

}

class ApiLogTypes {

    const Daily = 'daily';
    const Monthly = 'monthly';

}

class ConfigRedis {

    const Host = 'localhost';
    const Port = 6379;

}
