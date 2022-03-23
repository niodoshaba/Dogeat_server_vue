<?php

namespace Bang\Redis;

use Bang\Lib\ORM;

/**
 * @author Bang
 */
abstract class MultipleKeyValueTable extends RedisTableBase {

    protected function GetPropertiesWithoutKey() {
        $result = array();
        $key_params = $this->GetKeyParams();
        $params = ORM::GetPropertiesName($this);
        foreach ($params as $param) {
            if (in_array($param, $key_params)) {
                continue;
            }
            $result[] = $param;
        }
        return $result;
    }

    public function GetKeyByParamName($param_name) {
        $key = $this->GetKey();
        $result = "{$key}:{$param_name}";
        return $result;
    }

    public function Delete() {
        $redis = self::GetCurrentRedis();
        $params = $this->GetPropertiesWithoutKey();
        foreach ($params as $param_name) {
            $key = $this->GetKeyByParamName($param_name);
            $redis->Delete($key);
        }
    }

    public function IsExist() {
        $redis = self::GetCurrentRedis();
        $params = $this->GetPropertiesWithoutKey();
        foreach ($params as $param_name) {
            $key = $this->GetKeyByParamName($param_name);
            if (!$redis->Exists($key)) {
                return false;
            }
        }
        return true;
    }

    public function Update() {
        $redis = self::GetCurrentRedis();
        $params = $this->GetPropertiesWithoutKey();
        foreach ($params as $param_name) {
            $key = $this->GetKeyByParamName($param_name);
            $value = $this->{$param_name};
            $redis->Set($key, $value);
        }
    }

    public function Refresh() {
        $redis = self::GetCurrentRedis();
        $this->CheckKeyNotNull();
        $params = $this->GetPropertiesWithoutKey();
        foreach ($params as $param_name) {
            $key = $this->GetKeyByParamName($param_name);
            $this->{$param_name} = $redis->Get($key);
        }
    }

}
