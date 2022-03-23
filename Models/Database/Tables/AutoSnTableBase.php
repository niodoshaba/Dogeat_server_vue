<?php

namespace Models\Database\Tables;

use Bang\Lib\MySqlDb;
use Bang\MVC\DbContext;

/**
 * @author Bang
 */
abstract class AutoSnTableBase extends NormalTableBase {

    public function Insert() {
        $tablename = $this->GetTableName();
        $key = $this->GetKeyColumn();
        $params = MySqlDb::GetParamsByObject($this);
        unset($params[":{$key}"]);
        $this->{$key} = DbContext::QuickInsert($tablename, $params);
    }

}
