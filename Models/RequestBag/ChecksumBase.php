<?php

namespace Models\RequestBag;

/**
 * @author Bang
 */
class ChecksumBase extends Base {

    public $Checksum;

    public function Valid() {
        if ($this->GetChecksum() != $this->Checksum) {
            $this->ThrowException('Checksum fail!', \Models\ErrorCode::AuthenticationFail);
        }
    }

    public function GetChecksum() {
        $checksum_str = $this->GetChecksumString();
        $check_sum_from = md5($checksum_str . \ApiConfig::Key);
        return $check_sum_from;
    }

    public function GetChecksumString() {
        $array = get_object_vars($this);
        ksort($array);
        $check_sum = '';
        foreach ($array as $key => $value) {
            if ($key == 'controller' || $key == 'action' || $key == 'Checksum' || \Bang\Lib\eString::StartsWith($key, '_')) {
                continue;
            }
            $check_sum .= "{$key}:{$value},";
        }
        return $check_sum;
    }

}
