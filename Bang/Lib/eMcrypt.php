<?php

namespace Bang\Lib;

/**
 * @author Bang
 */
class eMcrypt {

    public static function Encode($key, $data) {
        $hash_string = $key;

        $hash = hash('SHA384', $hash_string, true);
        $app_cc_aes_key = substr($hash, 0, 32);
        $app_cc_aes_iv = substr($hash, 32, 16);

        $encrypt_method = 'AES-256-CBC';
        $result = openssl_encrypt($data, $encrypt_method, $app_cc_aes_key, 0, $app_cc_aes_iv);
        return $result;
    }

    public static function Decode($key, $encrypt_in_base64) {
        $hash_string = $key;

        $hash = hash('SHA384', $hash_string, true);
        $app_cc_aes_key = substr($hash, 0, 32);
        $app_cc_aes_iv = substr($hash, 32, 16);

        $encrypt_method = 'AES-256-CBC';
        $result = openssl_decrypt($encrypt_in_base64, $encrypt_method, $app_cc_aes_key, 0, $app_cc_aes_iv);
        return $result;
    }

}
