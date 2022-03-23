<?php

namespace Bang\Lib;

/**
 * 资料检查功能
 * @author Bang
 */
class Checker {

    public static function IsDate($string) {
        return self::Regexp($string, "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/");
    }

    public static function IsDateTime($date, $format = 'Y-m-d H:i:s') {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function IsEmail($input) {
        if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 检查是否为TUID
     * @param string $tuid
     * @return boolean
     */
    public static function IsTuid($tuid) {
        $bit_reg = "[0-9a-f]";
        $pattern = "/^({$bit_reg}{8}\-{$bit_reg}{4}\-{$bit_reg}{4}\-{$bit_reg}{4}\-{$bit_reg}{12})$/";
        $result = preg_match($pattern, $tuid);
        return $result == 1;
    }

    /**
     * @param string $value
     * @return boolean
     */
    public static function IsPostiveInt($value) {
        $is_int = is_numeric($value) && !eString::Contains($value, '.');
        $is_not_null = eString::IsNotNullOrSpace($value);
        $great_than_0 = intval($value) >= 0;
        return $is_not_null && $is_int && $great_than_0;
    }

    /**
     * @param type $value
     * @return boolean 
     */
    public static function IsPostiveNumber($value) {
        $is_number = is_numeric($value);
        $is_not_null = eString::IsNotNullOrSpace($value);
        $great_than_0 = intval($value) >= 0;
        return $is_not_null && $is_number && $great_than_0;
    }

    /**
     * 检查IP
     * @param string $input
     * @return boolean
     */
    public static function IP($input) {
        if (filter_var($input, FILTER_VALIDATE_IP)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 检查網址
     * @param string $input
     * @return boolean
     */
    public static function Url($input) {
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 正規表達示
     * @param string $input
     * @param string $regexp 正則式
     * @return boolean
     */
    public static function Regexp($input, $regexp) {
        $int_options = array(
            "options" =>
            array(
                "regexp" => $regexp
            )
        );
        if (filter_var($input, FILTER_VALIDATE_REGEXP, $int_options)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 檢查是否有匹配字元
     * @param string $input
     * @param string $characters ex:!,@,#,$,%,^,&,*,(,),+,|,~,\,=,-,.,<,>,/,?,:,",',;,[,],{,}
     * @return boolean
     */
    public static function Match($input, $characters) {
        $regexp = "/[";
        $array = eString::Split($characters, ",");
        foreach ($array as $value) {
            if (self::Regexp($value, "/[a-zA-Z0-9]/")) {
                if (eString::Contains($input, $value)) {
                    return true;
                }
            } else {
                $regexp.='\\' . $value;
            }
        }
        $regexp.= "]/";
        return self::Regexp($input, $regexp);
    }

    /**
     * 檢查字串,不包含特殊字元
     * @param string $input
     * @param integer $length_max 最大長度
     * @param integer $length_min 最小長度
     * @return boolean
     */
    public static function Word($input, $length_max = "", $length_min = 1) {
        return self::Regexp($input, "/^[a-zA-Z0-9]{{$length_min},{$length_max}}$/");
    }

    public static function MD5($input) {
        return 1 === preg_match('/^[a-f0-9]{32}$/', $input);
    }

    public static function Json($str) {
        return is_string($str) && is_array(json_decode($str, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

}
