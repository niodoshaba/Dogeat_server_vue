<?php

namespace Bang\Lib;

/**
 * @author Bang
 */
class MySqlDb {

    protected $pdo;
    protected $host;
    protected $name;
    protected $username;
    protected $password;
    protected $port;
    private $transaction_count;

    function __construct($host, $username, $password, $name = null, $port = 3306) {

        $this->host = $host;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;

        $pdo = new \PDO("mysql:host={$host};port={$port};charset=utf8", $username, $password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->exec("set names utf8;");
        if (eString::IsNotNullOrSpace($name)) {
            $pdo->exec("USE {$name};");
        }

        $this->pdo = $pdo;
        $this->transaction_count = 0;
        $this->table_exists = array();
    }

    /**
     * @param string $sql
     * @param array $params
     * @return \PDOStatement
     */
    public function Query($sql, $params = array()) {
        $con = $this->pdo;
        $stem = $con->prepare($sql);
        $stem->execute($params);
        return $stem;
    }

    /**
     * 執行Insert Query
     * @param string $sql Prepare SQL語法
     * @param array $params 傳入參數
     * @return string Insert后LastId
     */
    public function Insert($sql, $params = array()) {
        $con = $this->pdo;
        $stem = $con->prepare($sql);
        $stem->execute($params);
        return $con->lastInsertId();
    }

    /**
     * @param string $db_name
     * @return bool
     */
    public function IsDbExist($db_name) {
        $sql = "SHOW DATABASES LIKE '{$db_name}';";
        $stem = $this->Query($sql);
        return $stem->rowCount() == 1;
    }

    private $table_exists;

    /**
     * 判斷資料表是否存在
     * @param string $table_name
     * @return boolean 判斷結果
     */
    public function IsTableExist($table_name) {
        if (isset($this->table_exists[$table_name])) {
            return true;
        }

        $sql = "show tables like '{$table_name}'";
        $query_result = $this->Query($sql);
        $query_result->fetchAll(\PDO::FETCH_ASSOC);
        $row_count = $query_result->rowCount();
        if ($row_count > 0) {
            $this->table_exists[$table_name] = true;
            return true;
        } else {
            return false;
        }
    }

    public function BeginTransaction() {
        if ($this->transaction_count === 0) {
            $result = $this->pdo->beginTransaction();
            if (!$result) {
                throw new \Exception('Begin Transaction Error!', \Models\ErrorCode::DatabaseError);
            }
        }
        $this->transaction_count += 1;
    }

    public function Commit() {
        if ($this->transaction_count > 0) {
            $this->transaction_count -= 1;
            if ($this->transaction_count === 0) {
                $result = $this->pdo->commit();
                if (!$result) {
                    throw new \Exception('Commit Transaction Error!', \Models\ErrorCode::DatabaseError);
                }
            }
        }
    }

    public function Rollback() {
        if ($this->pdo->inTransaction()) {
            $result = $this->pdo->rollBack();
            $this->transaction_count = 0;
            if (!$result) {
                throw new \Exception('Rollback Transaction Error!', \Models\ErrorCode::DatabaseError);
            }
        }
    }

    public function Disconnect() {
        $this->pdo = null;
    }

    /**
     * @param string $tablename
     * @param string $params (参数以where开头将不会被Update,只会带入where语法中)
     * @return string last_insert_id
     */
    public function QuickInsert($tablename, $params) {
        $sql = $this->GetInsertQuery($tablename, $params);
        $result = $this->Insert($sql, $params);
        return $result;
    }

    private function GetInsertQuery($tablename, $params) {
        $keys = array();
        foreach ($params as $key => $value) {
            $keys[] = eString::Replace($key, ':', '');
        }
        $fields = "";
        $values = "";
        foreach ($keys as $key => $value) {
            if ($key > 0) {
                $fields .= ",";
                $values .= ",";
            }
            $fields .= "`{$value}`";
            $values .= " :{$value}";
        }
        $sql = "INSERT INTO `{$tablename}`($fields) VALUES ($values) ;";
        return $sql;
    }

    public function QuickInsertOrAdd($tablename, $params, $un_updates) {
        $keys = array();
        foreach ($params as $key => $value) {
            $keys[] = eString::Replace($key, ':', '');
        }
        $fields = "";
        $values = "";

        $count = 0;
        $set_sql = "";

        foreach ($keys as $key => $value) {
            // <editor-fold defaultstate="collapsed" desc="Inserts">

            if ($key > 0) {
                $fields .= ",";
                $values .= ",";
            }
            $fields .= "`{$value}`";
            $values .= " :{$value}";

            // </editor-fold>
            // <editor-fold defaultstate="collapsed" desc="For Update">

            if (!in_array($value, $un_updates)) {
                if ($count > 0) {
                    $set_sql .= ",";
                }
                $set_sql .= "`{$value}`=`{$value}`+VALUES(`{$value}`)";
                $count++;
            }

            // </editor-fold>
        }
        $inser_sql = "INSERT INTO `{$tablename}`($fields) VALUES ($values) ";
        $sql = "{$inser_sql} ON DUPLICATE KEY UPDATE {$set_sql} ;";
        $stem = $this->Query($sql, $params);
        return $stem;
    }

    public function QuickInsertOrUpdate($tablename, $params, $un_updates) {
        $keys = array();
        foreach ($params as $key => $value) {
            $keys[] = eString::Replace($key, ':', '');
        }
        $fields = "";
        $values = "";

        $count = 0;
        $set_sql = "";

        foreach ($keys as $key => $value) {
            // <editor-fold defaultstate="collapsed" desc="Inserts">

            if ($key > 0) {
                $fields .= ",";
                $values .= ",";
            }
            $fields .= "`{$value}`";
            $values .= " :{$value}";

            // </editor-fold>
            // <editor-fold defaultstate="collapsed" desc="For Update">

            if (!in_array($value, $un_updates)) {
                if ($count > 0) {
                    $set_sql .= ",";
                }
                $set_sql .= "`{$value}`=VALUES(`{$value}`)";
                $count++;
            }

            // </editor-fold>
        }
        $inser_sql = "INSERT INTO `{$tablename}`($fields) VALUES ($values) ";
        $sql = "{$inser_sql} ON DUPLICATE KEY UPDATE {$set_sql} ;";
        $stem = $this->Query($sql, $params);
        return $stem;
    }

    /**
     * 
     * @param string $tablename
     * @param string $where
     * @param string $params (参数以where开头将不会被Update,只会带入where语法中)
     * @return \PDOStatement
     */
    public function QuickUpdate($tablename, $where, $params) {
        $keys = array();
        foreach ($params as $key => $value) {
            $keys[] = eString::Replace($key, ':', '');
        }

        $set_sql = "";
        $count = 0;
        foreach ($keys as $value) {
            if (eString::StartsWith($value, 'where')) {
                continue;
            }
            if ($count > 0) {
                $set_sql .= ",";
            }
            $set_sql .= "`{$value}`=:{$value}";
            $count++;
        }

        $sql = "UPDATE `{$tablename}` SET {$set_sql} WHERE ({$where})";
        $result = $this->Query($sql, $params);
        return $result;
    }

    /**
     * Must query by SQL_CALC_FOUND_ROWS before this function
     */
    public function GetSqlCalcFoundRows() {
        $sql = "SELECT FOUND_ROWS() as totals;";
        $stem = $this->Query($sql);
        $data = $stem->fetch(2);
        return $data['totals'];
    }

    public static function GetParamsByObject($obj) {
        $datas = ORM::ObjectToArray($obj);
        $result = array();
        foreach ($datas as $key => $value) {
            $result[":{$key}"] = $value;
        }
        return $result;
    }

}
