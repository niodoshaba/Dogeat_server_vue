<?php

namespace Models\Database\DailyTables;

use Bang\Lib\eString;
use Bang\MVC\DbContext;
use Models\Current;
use Models\Database\LogTables;
use PDO;

class DailyTable {

    private static $yyyyMMdd = null;

    public static function GetYmd() {
        if (self::$yyyyMMdd == null) {
            $datetime = Current\Request::GetLibDatetime();
            self::$yyyyMMdd = $datetime->Format('Ymd');
        }
        return self::$yyyyMMdd;
    }

    public static function ApiLogs($yyyyMMdd = '') {

        if (eString::IsNullOrSpace($yyyyMMdd)) {
            $yyyyMMdd = self::GetYmd();
        }
        $table_name = "api_logs";
        $sql_without_create = LogTables::CreateSql;
        return self::GetSplitTableName($table_name, $sql_without_create, $yyyyMMdd);
    }

    /**
     * @param string $table_name 未分割資料表名稱
     * @param string $create_table_sql_without_create 不包含(CREATE TABLE `TableName`)敘述的完整SQL
     * @return string 實際資料表名稱
     */
    private static function GetSplitTableName($table_name, $create_table_sql_without_create, $yyyyMMdd = '') {

        if (eString::IsNullOrSpace($yyyyMMdd)) {
            $yyyyMMdd = self::GetYmd();
        }

        $split_table_name = "{$table_name}_{$yyyyMMdd}";
        $sql = "show tables like '{$split_table_name}'";
        $query_result = DbContext::Query($sql);
        $query_result->fetchAll(PDO::FETCH_ASSOC);
        $row_count = $query_result->rowCount();

        if ($row_count == 0) { //沒有該月表
            $create_sql = "CREATE TABLE `{$split_table_name}` " . $create_table_sql_without_create;
            DbContext::Query($create_sql);
        }

        return $split_table_name;
    }

}
