<?php

namespace Bang\Lib;

use Config;
use ConfigMemecache;
use Exception;
use Memcache;
use Models\ErrorCode;

/**
 * 應用程式單例存放(Registry實作)
 * @author Bang
 */
class eMemcache {

    /**
     * 將一個物件加入store中
     * @param string $key 物件名稱(索引,為空時將直接使用該物件類別名稱)
     * @param mixed $data 要儲存的物件
     * @param int $expire_seconds 资料过期时间(秒)
     * @return bool 回傳是否成功
     */
    public static function Set($key, $data, $expire_seconds = 0) {
        $name = self::StroeName($key);
        $memcache = self::Current();
        return $memcache->set($name, $data, 0, $expire_seconds);
    }

    public static function ContainKey($key) {
        $result = self::Get($key);
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * 從註冊表中取得物件
     * @param string $key 物件名稱
     * @return mixed 物件
     */
    public static function Get($key) {
        $name = self::StroeName($key);
        $memcache = self::Current();
        $result = $memcache->get($name);
        return $result;
    }

    /**
     * 從註冊中刪除物件
     * @param string $key 物件名稱
     */
    public static function Delete($key) {
        $name = self::StroeName($key);
        $memcache = self::Current();
        $memcache->delete($name);
    }

    /**
     * 統一網站存取名稱使用
     * @param string $key 輸入名稱
     * @return string 存取名稱
     */
    private static function StroeName($key) {
        $site_hash = md5(Config::$SiteName);
        return "{$site_hash}_{$key}";
    }

    private static $_current = NULL;

    /**
     * 取得目前self
     * @return self self
     */
    private static function Current() {
        if (is_null(self::$_current)) {
            if (ConfigMemecache::Enable) {
                self::$_current = new Memcache();
                self::$_current->connect(ConfigMemecache::Host, ConfigMemecache::Port);
            } else {
                throw new Exception("系统没有启动Memcache！", ErrorCode::UnKnownError);
            }
        }
        return self::$_current;
    }

}
