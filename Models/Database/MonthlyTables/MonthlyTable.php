<?php

namespace Models\Database\MonthlyTables;

use Bang\Lib\eString;
use Bang\MVC\DbContext;
use Models\Current;
use Models\Database\LogTables;
use PDO;

class MonthlyTable {

    private static $yyyyMM = null;

    public static function GetYm() {
        if (self::$yyyyMM == null) {
            $datetime = Current\Request::GetLibDatetime();
            self::$yyyyMM = $datetime->ToYYYYmm();
        }
        return self::$yyyyMM;
    }

    public static function IdGenerator($yyyyMM = '') {
        if (eString::IsNullOrSpace($yyyyMM)) {
            $yyyyMM = self::GetYm();
        }
        $table_name = "id_generator";
        $sql_without_create = "(
                                    `id`  bigint(20) NOT NULL AUTO_INCREMENT ,
                                    `content`  varchar(1) CHARACTER SET ascii COLLATE ascii_general_ci NULL DEFAULT NULL ,
                                    PRIMARY KEY (`id`)
                                )
                                ENGINE=InnoDB
                                DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
                                ROW_FORMAT=COMPACT
                                ;";
        return self::GetSplitTableName($table_name, $sql_without_create, $yyyyMM);
    }

    public static function LoadingRecords($yyyyMM = '') {
        if (eString::IsNullOrSpace($yyyyMM)) {
            $yyyyMM = self::GetYm();
        }
        $table_name = "loading_records";
        $sql_without_create = " (
                                    `datetime_minutes`  varchar(30) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL ,
                                    `action`  varchar(50) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL ,
                                    `count`  bigint(20) NOT NULL DEFAULT 0 ,
                                    `success`  bigint(20) NOT NULL DEFAULT 0 ,
                                    `error`  bigint(11) NOT NULL DEFAULT 0 ,
                                    `total_span_seconds`  decimal(24,4) NOT NULL DEFAULT 0.0000 ,
                                    PRIMARY KEY (`datetime_minutes`, `action`),
                                    INDEX `index1` USING BTREE (`action`) 
                                )
                                ENGINE=InnoDB
                                DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
                                ROW_FORMAT=COMPACT
                                ;";
        return self::GetSplitTableName($table_name, $sql_without_create, $yyyyMM);
    }

    public static function ApiLogs($yyyyMM = '') {

        if (eString::IsNullOrSpace($yyyyMM)) {
            $yyyyMM = self::GetYm();
        }
        $table_name = "api_logs";
        $sql_without_create = LogTables::CreateSql;
        return self::GetSplitTableName($table_name, $sql_without_create, $yyyyMM);
    }

    /**
     * @param string $table_name 未分割資料表名稱
     * @param string $create_table_sql_without_create 不包含(CREATE TABLE `TableName`)敘述的完整SQL
     * @return string 實際資料表名稱
     */
    private static function GetSplitTableName($table_name, $create_table_sql_without_create, $yyyyMM = '') {

        if (eString::IsNullOrSpace($yyyyMM)) {
            $yyyyMM = self::GetYm();
        }

        $split_table_name = "{$table_name}_{$yyyyMM}";
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
