<?php

namespace Models\Current;

use Models\Database\api_logs;

/**
 * @author Bang
 */
class Current {

    /**
     * @var api_logs
     */
    private static $_Logs = null;

    /**
     * @return api_logs
     */
    public static function GetLogger() {
        if (null == Current::$_Logs) {
            Current::$_Logs = new api_logs();
        }
        return Current::$_Logs;
    }

}
