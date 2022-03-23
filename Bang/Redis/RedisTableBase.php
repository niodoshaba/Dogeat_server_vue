<?php

namespace Bang\Redis;

use Bang\Lib\eString;
use Exception;
use Models\ErrorCode;
use Bang\Redis\RedisBase;

/**
 * @author Bang
 */
abstract class RedisTableBase extends RedisBase {

    protected abstract function GetTablename();

    protected abstract function GetKeyParams();

    public function GetKey() {
        $keys = $this->GetKeyParams();
        $result = $this->GetTablename();
        foreach ($keys as $key) {
            $value = $this->{$key};
            $result .= ":{$key}={$value}";
        }
        return $result;
    }

    public function Delete() {
        $key = $this->GetKey();
        $redis = self::GetCurrentRedis();
        $response = $redis->Delete($key);
        return $response;
    }

    public function IsExist() {
        $this->CheckKeyNotNull();
        $key = $this->GetKey();
        $redis = self::GetCurrentRedis();
        $result = $redis->Exists($key);
        return $result;
    }

    public function CheckKeyNotNull() {
        $keys = $this->GetKeyParams();
        foreach ($keys as $key) {
            if (eString::IsNullOrSpace($this->{$key})) {
                $tablename = $this->GetTablename();
                throw new Exception("The redis table '{$tablename}' check key({$key}) is not already!", ErrorCode::WrongParameter);
            }
        }
    }

}
