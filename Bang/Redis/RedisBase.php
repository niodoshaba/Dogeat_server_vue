<?php

namespace Bang\Redis;

/**
 * @author Bang
 */
class RedisBase {

    private static $redis;

    /**
     * @return BangRedis
     */
    protected static function GetCurrentRedis() {
        if (!isset(self::$redis)) {
            $redis = new BangRedis();
            self::$redis = $redis;
        }
        return self::$redis;
    }

}
