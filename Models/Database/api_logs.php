<?php

namespace Models\Database;

use ApiConfig;
use ApiLogTypes;
use Bang\Lib\eDateTime;
use Bang\Lib\eString;
use Bang\Lib\MySqlDb;
use Bang\MVC\DbContext;
use Bang\MVC\Route;
use Models\Current\Request;
use Models\Database\DailyTables\DailyTable;
use Models\Database\MonthlyTables\MonthlyTable;

/**
 * @author Bang
 */
class api_logs {

    function __construct() {
        
    }

    public $id;
    public $day;
    public $hour;
    public $action;
    public $request;
    public $response;
    public $error_code;
    public $request_id;
    public $client_request_id;
    public $time;
    public $span_ms;

    public function InitRequest($action = "", $request = "", eDateTime $time = null) {
        if (eString::IsNullOrSpace($action)) {
            $route = Route::Current();

            $action = "{$route->controller}/{$route->action}";
        }
        if (eString::IsNullOrSpace($request)) {
            $request = http_build_query($_GET);
        }
        if (null === $time) {
            $time = new eDateTime();
        }
        $this->action = $action;
        $this->request = $request;
        $this->time = $time->Format('Y-m-d H:i:s');
        $this->day = $time->Format('d');
        $this->hour = $time->Format('H');
        $this->request_id = Request::GetId();
    }

    public static function GetTablename() {
        if (ApiConfig::LogType == ApiLogTypes::Daily) {
            $tablename = DailyTable::ApiLogs();
        } else {
            $tablename = MonthlyTable::ApiLogs();
        }
        return $tablename;
    }

    public function Insert() {
        if (!isset($this->request)) {
            $this->InitRequest();
        }
        $tablename = self::GetTablename();
        $params = MySqlDb::GetParamsByObject($this);
        unset($params[':id']);
        $id = DbContext::QuickInsert($tablename, $params);
        $this->id = $id;
        return $id;
    }

    public function Update() {
        $table = self::GetTablename();
        $params = MySqlDb::GetParamsByObject($this);
        unset($params[':id']);
        $params[':where_id'] = $this->id;
        $stem = DbContext::QuickUpdate($table, " `id`=:where_id ", $params);
        $result = $stem->rowCount() === 1;
        return $result;
    }

}
