<?php

namespace Bang\Redis;

use Models\Current\Request;

/**
 * @author Bang
 */
class SnGenerator extends RedisBase {

    const TableName = 'SnGenerator';

    public static function GetKey($yyyymm = null) {
        if (null === $yyyymm) {
            $datetime = Request::GetLibDatetime();
            $yyyymm = $datetime->ToYYYYmm();
        }
        $tablename = self::TableName;
        $result = "{$tablename}:{$yyyymm}";
        return $result;
    }

    /**
     * 取得單純數字SN
     * @return int
     */
    public static function NewSn() {
        $key = self::GetKey();
        $redis = self::GetCurrentRedis();
        $response = $redis->Incr($key);
        return $response;
    }

    /**
     * 取得包含年月和三位數代碼的SN
     * @param string $code 輸入三位代碼 Ex:G01
     * @return string ex:{yyyymm}
     */
    public static function GetNewIdWithYmAndCode($code) {
        $sn = self::NewSn();
        $datetime = Request::GetLibDatetime();
        $yyyymm = $datetime->ToYYYYmm();
        $id_str = str_pad($sn, 15, '0', STR_PAD_LEFT);
        $result = "{$yyyymm}{$code}{$id_str}";
        return $result;
    }

    /**
     * 取得包含年月的SN
     * @return string ex:{yyyymm}
     */
    public static function GetNewIdWithYm() {
        $sn = self::NewSn();
        $datetime = Request::GetLibDatetime();
        $yyyymm = $datetime->ToYYYYmm();
        $id_str = str_pad($sn, 15, '0', STR_PAD_LEFT);
        $result = "{$yyyymm}{$id_str}";
        return $result;
    }

    public static function GetYmById($id_with_Ym) {
        $result = substr($id_with_Ym, 0, 6);
        return $result;
    }

}
