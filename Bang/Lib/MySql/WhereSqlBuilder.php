<?php

namespace Bang\Lib\MySql;

use Bang\Lib\eString;

/**
 * @author Bang
 */
class WhereSqlBuilder {

    private $sql;
    private $params;

    function __construct($start_where_sql = "WHERE true ") {
        $this->sql = $start_where_sql;
        $this->params = array();
    }

    public function ToCacheKey() {
        $params = $this->params;
        $result = '';
        foreach ($params as $key => $value) {
            $result .= "{$key}={$value},";
        }
        return $result;
    }

    /**
     * @param type $name
     * @param type $table_name
     * @return NameValue
     */
    private function GetNameMap($name, $table_name = null) {
        if (eString::IsNotNullOrSpace($table_name)) {
            $result = new NameValue("`{$table_name}`.`{$name}`", ":{$table_name}_{$name}");
        } else {
            $result = new NameValue("`{$name}`", ":{$name}");
        }
        return $result;
    }

    public function AndBetweenOrEqual($name, $from_value, $to_value, $table_name = null) {
        $name_value = $this->GetNameMap($name, $table_name);
        $this->sql .= "AND ({$name_value->name} >= {$name_value->value}_from AND {$name_value->name} <= {$name_value->value}_to) ";
        $this->params[$name_value->value . '_from'] = $from_value;
        $this->params[$name_value->value . '_to'] = $to_value;
    }

    public function AndLessOrEqual($name, $value, $table_name = null) {
        $name_value = $this->GetNameMap($name, $table_name);
        $this->sql .= "AND {$name_value->name} <= {$name_value->value} ";
        $this->params[$name_value->value] = $value;
    }

    public function AndGreaterOrEqual($name, $value, $table_name = null) {
        $name_value = $this->GetNameMap($name, $table_name);
        $this->sql .= "AND {$name_value->name} >= {$name_value->value} ";
        $this->params[$name_value->value] = $value;
    }

    public function Equal($name, $value, $table_name = null) {
        $name_value = $this->GetNameMap($name, $table_name);
        $this->sql .= " {$name_value->name} = {$name_value->value} ";
        $this->params[$name_value->value] = $value;
    }

    public function OrEqual($name, $value, $table_name = null) {
        $this->sql .= "OR ";
        $this->Equal($name, $value, $table_name);
    }

    public function AndStartScratch() {
        $this->sql .= "AND (";
    }

    public function EndScratch() {
        $this->sql .= ") ";
    }

    public function AndEqual($name, $value, $table_name = null) {
        $this->sql .= "AND ";
        $this->Equal($name, $value, $table_name);
    }

    public function AndIsNull($name, $table_name = null) {
        $name_value = $this->GetNameMap($name, $table_name);
        $this->sql .= "AND {$name_value->name} IS NULL ";
    }

    public function AndIsNotNull($name, $table_name = null) {
        $name_value = $this->GetNameMap($name, $table_name);
        $this->sql .= "AND {$name_value->name} IS NOT NULL ";
    }

    public function AndContains($name, $value, $table_name = null) {
        $name_value = $this->GetNameMap($name, $table_name);
        $this->sql .= "AND {$name_value->name} LIKE {$name_value->value} ";
        $this->params[$name_value->value] = "%{$value}%";
    }

    public function GetSql() {
        return $this->sql;
    }

    public function GetParams() {
        return $this->params;
    }

    public function MergeParams($params) {
        foreach ($params as $key => $value) {
            $this->params[$key] = $value;
        }
    }

}
