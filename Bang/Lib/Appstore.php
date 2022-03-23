<?php

namespace Bang\Lib;

/*
 * 用來存放各種應用程式會使用到的參數及物件
 */

/**
 * 應用程式單例存放(Registry實作)
 * @author Bang
 */
class Appstore {

    /**
     * 將一個物件加入store中
     * @param string $key 物件名稱(索引,為空時將直接使用該物件類別名稱)
     * @param mixed $data 要儲存的物件
     * @return bool 回傳是否成功
     */
    public static function Set($key, $data) {
        $name = Appstore::StroeName($key);
        return Appstore::Current()->Set($name, $data);
    }

    /**
     * 從註冊表中取得物件
     * @param string $key 物件名稱,{@see self::set()}
     * @param mixed $init_data 預設物件(為空時存入物件)
     * @return mixed 物件
     */
    public static function Get($key, $init_data = FALSE) {
        $name = Appstore::StroeName($key);
        $result = Appstore::Current()->Get($name);
        if (!$result) {
            Appstore::Set($key, $init_data);
            $result = $init_data;
        }
        return $result;
    }

    /**
     * 從註冊中刪除物件
     * @param string $key 物件名稱
     * @return void
     */
    public static function Delete($key) {
        $name = Appstore::StroeName($key);
        Appstore::Current()->Delete($name);
    }

    /**
     * 統一網站存取名稱使用
     * @param string $key 輸入名稱
     * @return string 存取名稱
     */
    private static function StroeName($key) {
        return \Config::$SiteName . "_" . $key;
    }

    private static $_current = NULL;

    /**
     * 取得目前Memcache
     * @return eMemcache Memcache
     */
    private static function Current() {
        if (is_null(Appstore::$_current)) {
            if (\ConfigMemecache::Enable) {
                Appstore::$_current = new eMemcache();
            } else {
                Appstore::$_current = new Registry();
            }
        }
        return Appstore::$_current;
    }

}
