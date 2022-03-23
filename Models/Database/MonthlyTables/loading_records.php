<?php

namespace Models\Database\MonthlyTables;

use Bang\Lib\MySqlDb;
use Bang\MVC\DbContext;
use Exception;
use Models\Current\Request;
use Models\ErrorCode;

/**
 * @author Bang
 */
class loading_records {

    public $datetime_minutes;
    public $action;
    public $count;
    public $success;
    public $error;
    public $total_span_seconds;

    /**
     * @param type $action
     * @param type $count
     * @param type $span_seconds
     * @param type $success
     * @param type $error
     */
    public static function AddRecords($action, $count = 0, $span_seconds = 0.0, $success = 0, $error = 0) {
        $data = new loading_records();
        $data->datetime_minutes = Request::GetDatetimeToMinutes();
        $data->action = $action;
        $data->count = $count;
        $data->success = $success;
        $data->error = $error;
        $data->total_span_seconds = $span_seconds;
        $data->InsertOrAdd();
    }

    public function InsertOrAdd() {
        $tablename = MonthlyTable::LoadingRecords();
        $params = MySqlDb::GetParamsByObject($this);
        $un_updates = array(
            'datetime_minutes',
            'action',
        );
        $stem = DbContext::QuickInsertOrAdd($tablename, $params, $un_updates);
        if ($stem->rowCount() === 0) {
            throw new Exception('The loading records add failed!', ErrorCode::UnKnownError);
        }
    }

}
