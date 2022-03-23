<?php

namespace Bang\Redis;

/**
 * @author Bang
 */
abstract class KeyJsonTable extends RedisTableBase {

    public function Update() {
        $key = $this->GetKey();
        $redis = self::GetCurrentRedis();
        $data = json_encode($this);
        $redis->Set($key, $data);
    }

    public function Refresh() {
        $key = $this->GetKey();
        $redis = self::GetCurrentRedis();
        $json = $redis->Get($key);
        if (null == $json) {
            $array = array();
        } else {
            $array = json_decode($json, 1);
        }
        foreach ($array as $key => $value) {
            $this->{$key} = $value;
        }
    }

}
