<?php

namespace Models\ControllerBase;

use ApiConfig;
use Bang\Lib\eString;
use Bang\MVC\ControllerBase;
use Bang\MVC\Route;
use Models\Current\Current;
use Models\Current\Request;
use Models\Database\MonthlyTables\loading_records;

/**
 * @author Bang
 */
class ApiControllerBase extends ControllerBase {

    private $start_mtime;
    private $current_action;

    function __construct() {
        $this->start_mtime = microtime(1);
        $route = Route::Current();
        $this->current_action = "{$route->controller}/{$route->action}";

        if (ApiConfig::LoadingRecords) {
            loading_records::AddRecords($this->current_action, 1);
        }

        if (ApiConfig::LogRequest || ApiConfig::LogResponse || ApiConfig::LogError) {
            $log = Current::GetLogger();
            $request = http_build_query($_GET);
            $time = Request::GetLibDatetime();
            $log->InitRequest($this->current_action, $request, $time);
            if (ApiConfig::LogRequest) {
                $log->Insert();
            }
        }
    }

    /**
     * 以 Json 字串回傳json格式
     * @param string $json_str 傳入JSON格式字串，為空時將自動傳TaskResult並IsSuccess為true
     */
    protected function JsonContent($json_str) {
        $end_mtime = microtime(1);
        $start_mtime = $this->start_mtime;
        $span_mtime = round($end_mtime - $start_mtime, 4);
        $is_response_error = false;
        $need_to_know_error = ApiConfig::LogError || ApiConfig::LoadingRecords;
        if ($need_to_know_error && eString::StartsWith(trim($json_str), '{"IsSuccess":false')) {
            $is_response_error = true;
        }

        if (ApiConfig::LoadingRecords) {
            $error = 0;
            $success = 1;
            if ($is_response_error) {
                $error = 1;
                $success = 0;
            }
            loading_records::AddRecords($this->current_action, 0, $span_mtime, $success, $error);
        }

        if (ApiConfig::LogResponse || ApiConfig::LogError) {
            $error_code = 0;
            if ($is_response_error) {
                //Error發生時我們建議將回傳錯誤代碼放置在Value或Value下的error_code
                $obj = json_decode($json_str, 1);
                if (isset($obj['Value']) && is_array($obj['Value']) && isset($obj['Value']['error_code'])) {
                    $error_code = $obj['Value']['error_code'];
                } else if (isset($obj['Value']) && !is_array($obj['Value'])) {
                    $error_code = $obj['Value'];
                }
            }

            $log = Current::GetLogger();
            $log->error_code = $error_code;
            $log->response = $json_str;
            $log->span_ms = $span_mtime;
            if (ApiConfig::LogResponse) {
                if (ApiConfig::LogRequest) {
                    $log->Update();
                } else {
                    $log->Insert();
                }
            }
            if ($is_response_error && ApiConfig::LogError) {
                $log->action = "Error:" . $log->action;
                $log->Insert();
            }
        }
        parent::JsonContent($json_str);
    }

}
