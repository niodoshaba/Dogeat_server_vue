<?php

namespace Bang\Lib;

/**
 * SQL 呼叫使用Bag,先Prepare後在執行
 * @author Bang
 */
class SqlBag {

    /**
     * 建立SqlBag
     * @param string $PrepareSql
     * @param array $Parameters
     */
    function __construct($PrepareSql, $Parameters) {
        $this->PrepareSql = $PrepareSql;
        $this->Parameters = $Parameters;
    }

    /**
     * @var string 準備好的Sql
     */
    public $PrepareSql;

    /**
     * @var array 即將注入的欄位與值
     */
    public $Parameters;

}
