<?php

namespace Models\API;

use ApiConfig;
use Bang\Abstracts\IApiLogger;
use Exception;
use Models\Database\api_logs;
use Models\Database\MonthlyTables\loading_records;

/**
 * @author Bang
 */
class ApiLogger implements IApiLogger {

    function __construct() {
        $this->is_request_init = false;
    }

    /**
     * @var api_logs 
     */
    private $log;
    private $start_mtime;
    private $is_request_init;

    public function EndWithResponse($is_success, $response) {
        $this->log->response = $response;
        $this->log->error_code = $is_success;
        $end_mtime = microtime(1);
        $start_mtime = $this->start_mtime;
        $span_mtime = round($end_mtime - $start_mtime, 4);
        $this->log->span_ms = $span_mtime;
        if (ApiConfig::LogResponse) {
            if (ApiConfig::LogRequest) {
                $this->log->Update();
            } else {
                $this->log->Insert();
            }
        }
        if (ApiConfig::LoadingRecords) {
            loading_records::AddRecords($this->log->action, 0, $span_mtime, 1, 0);
        }
    }

    public function Error(Exception $ex) {
        $this->log->response = "Error:" . $ex->getMessage() . "\n" . $ex->getTraceAsString();
        $this->log->error_code = $ex->getCode();

        $end_mtime = microtime(1);
        $start_mtime = $this->start_mtime;
        $span_mtime = round($end_mtime - $start_mtime, 4);
        $this->log->span_ms = $span_mtime;
        if (ApiConfig::LogError || ApiConfig::LogResponse) {
            if (ApiConfig::LogRequest) {
                $this->log->Update();
            } else {
                $this->log->Insert();
            }
        }
        if (ApiConfig::LoadingRecords) {
            loading_records::AddRecords($this->log->action, 0, $span_mtime, 0, 1);
        }
    }

    public function InitRequest($uri, $request) {
        $this->start_mtime = microtime(1);
        $this->log = new api_logs();
        $this->log->InitRequest($uri, $request);
        $this->is_request_init = true;
        if (ApiConfig::LogRequest) {
            $this->log->Insert();
        }
        if (ApiConfig::LoadingRecords) {
            loading_records::AddRecords($this->log->action, 1);
        }
    }

    public function IsInitRequest() {
        return $this->is_request_init;
    }

}
