<?php

namespace Bang\MVC;

use Bang\Lib\MySqlDb;
use Config;
use PDOStatement;

/**
 * 資料庫類型容器基底
 * @author Bang
 */
class DbContext {

    /**
     * 實作單例連線
     * @var MySqlDb 連線
     */
    private static $DB = NULL;

    /**
     * 取得PDO連線
     * @return MySqlDb 連線物件
     */
    public static function GetConnection() {
        if (is_null(self::$DB)) {
            $host = Config::DbHost;
            $name = Config::DbName;
            $username = Config::DbUser;
            $password = Config::DbPassword;
            $db = new MySqlDb($host, $username, $password, $name);
            self::$DB = $db;
        }
        return self::$DB;
    }


    /**
     * 執行Query
     * @param string $sql Prepare SQL語法
     * @param array $params 傳入參數
     * @return PDOStatement 查詢結果
     */
    public static function Query($sql, $params = array()) {
        $db = self::GetConnection();
        return $db->Query($sql, $params);
    }

    /**
     * @param string $tablename
     * @param array $params
     * @param array $un_updates ex: array( 'id', ...  )
     * @return PDOStatement 查詢結果
     */
    public static function QuickInsertOrAdd($tablename, $params, $un_updates) {
        $db = self::GetConnection();
        return $db->QuickInsertOrAdd($tablename, $params, $un_updates);
    }

    /**
     * @param string $tablename
     * @param array $params
     * @param array $un_updates ex: array( 'id', ...  )
     * @return PDOStatement 查詢結果
     */
    public static function QuickInsertOrUpdate($tablename, $params, $un_updates) {
        $db = self::GetConnection();
        return $db->QuickInsertOrUpdate($tablename, $params, $un_updates);
    }

    /**
     * 執行Insert Query
     * @param string $sql Prepare SQL語法
     * @param array $params 傳入參數
     * @return string Insert后LastId
     */
    public static function Insert($sql, $params = array()) {
        $db = self::GetConnection();
        return $db->Insert($sql, $params);
    }

    /**
     * 判斷資料表是否存在
     * @param string $table_name
     * @return boolean 判斷結果
     */
    public static function IsTableExist($table_name) {
        $db = self::GetConnection();
        return $db->IsTableExist($table_name);
    }

    public static function BeginTransaction() {
        $db = self::GetConnection();
        return $db->BeginTransaction();
    }

    public static function Commit() {
        $db = self::GetConnection();
        return $db->Commit();
    }

    public static function Rollback() {
        $db = self::GetConnection();
        return $db->Rollback();
    }

    public static function Disconnect() {
        $db = self::GetConnection();
        $db->Disconnect();
        self::$DB = null;
    }

    /**
     * @param string $tablename
     * @param string $params (参数以where开头将不会被Update,只会带入where语法中)
     * @return string last_insert_id
     */
    public static function QuickInsert($tablename, $params) {
        $db = self::GetConnection();
        return $db->QuickInsert($tablename, $params);
    }

    /**
     * 
     * @param string $tablename
     * @param string $where
     * @param string $params (参数以where开头将不会被Update,只会带入where语法中)
     * @return PDOStatement
     */
    public static function QuickUpdate($tablename, $where, $params) {
        $db = self::GetConnection();
        return $db->QuickUpdate($tablename, $where, $params);
    }

    /**
     * Must query by SQL_CALC_FOUND_ROWS before this function
     * @return int
     */
    public static function GetSqlCalcFoundRows() {
        $db = self::GetConnection();
        $result = $db->GetSqlCalcFoundRows();
        return $result;
    }

}
