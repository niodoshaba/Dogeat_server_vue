<?php

namespace Bang\Lib;

/**
 * 字串(String)擴增功能
 */
class eString {

    public static function SplitByLength($string, $split_length = 1, $encoding = null) {
        if (is_null($encoding)) {
            $encoding = mb_internal_encoding();
        }
        if ($split_length < 1) {
            throw new Exception('The split length number should be positive!');
        }
        $return_value = array();
        $string_length = mb_strlen($string, $encoding);
        for ($i = 0; $i < $string_length; $i += $split_length) {
            $return_value[] = mb_substr($string, $i, $split_length, $encoding);
        }
        return $return_value;
    }
    /**
     * 解码HTML
     * @param eString $string
     * @return eString
     */
    public static function DecodeHtml($string) {
        return html_entity_decode($string);
    }

    /**
     * 改为HTML编码
     * @param eString $str
     * @return eString
     */
    public static function EncodeHtml($str) {
        return htmlentities($str, ENT_QUOTES, 'utf-8');
    }

    /**
     * 将阵列字串结合成单一字串
     * @param array $strs 字串阵列
     * @param eString $separated 分隔字串
     * @param eString $symbol 字串符号
     * @return eString 结果字串
     */
    public static function ToSingleString($strs, $separated = ",", $symbol = "'") {
        $result = "";
        $count = 0;
        foreach ($strs as $str) {
            if ($count > 0) {
                $result .= $separated;
            }
            $result .= $symbol . $str . $symbol;
            $count++;
        }
        return $result;
    }

    /**
     * 判斷字串不是空值或是空白
     * @param eString $str 判斷字串
     * @return bool 判斷結果
     */
    public static function IsNotNullOrSpace($str) {
        return !eString::IsNullOrSpace($str);
    }

    /**
     * 判斷字串是空值或是空白
     * @param eString $str 判斷字串
     * @return bool 判斷結果
     */
    public static function IsNullOrSpace($str) {
        return (!isset($str) || trim($str) === '');
    }

    /**
     * @param type $src_str
     * @param type $char
     * @param type $start_index
     * @param type $count
     * @return string
     */
    public static function RepleaseCharByIndex($src_str, $char, $start_index, $count) {
        $account = \str_split($src_str);
        $new_account = "";
        $index = 1;
        foreach ($account as $value) {
            if ($index >= $start_index && $index <= ($start_index + $count - 1)) {
                $new_account .= $char;
            } else {
                $new_account .= $value;
            }
            $index++;
        }
        return $new_account;
    }

    /**
     * 刪除字串開頭文字
     * @param eString $input 輸入值
     * @param eString $prefix 開頭文字
     * @return eString 刪除後字串
     */
    public static function RemovePrefix($input, $prefix) {
        $str = $input;
        if (self::StartsWith($input, $prefix)) {
            $str = substr($input, strlen($prefix));
        }
        return $str;
    }

    /**
     * 刪除字串結尾文字
     * @param eString $input 輸入值
     * @param eString $suffix 結尾文字
     * @return eString 刪除後字串
     */
    public static function RemoveSuffix($input, $suffix) {
        $str = $input;
        if (self::EndsWith($input, $suffix)) {
            $str = substr($input, 0, strlen($input) - strlen($suffix));
        }
        return $str;
    }

    /**
     * 判斷字串是否為$test開頭
     * @param eString $input 輸入值
     * @param eString $test 比對值
     * @return bool 判斷結果
     */
    public static function StartsWith($input, $test) {
        return strpos($input, $test) === 0;
    }

    /**
     * 判斷字串是否為$test結尾
     * @param eString $input 輸入值
     * @param eString $test 比對值
     * @return bool 判斷結果
     */
    public static function EndsWith($input, $test) {
        return $test === "" || substr($input, -strlen($test)) === $test;
    }

    /**
     * 字串取代
     * @param eString $input 輸入完整字串
     * @param eString $target_str 尋找目標？
     * @param eString $replace_to 取代為？
     * @return eString 結果字串
     */
    public static function Replace($input, $target_str, $replace_to) {
        return str_replace($target_str, $replace_to, $input);
    }

    /**
     * 將QueryString轉為陣列
     * @param eString $input QueryString
     * @return array 陣列結果
     */
    public static function ParseQueryStringToArray($input) {
        $resultArray = array();
        parse_str($input, $resultArray);
        return $resultArray;
    }

    /**
     * 判断字串是否包含某字串
     * @param eString $input 字串 (ex:'test')
     * @param eString $test 是否包含的字串 (ex:'es')
     * @return bool
     */
    public static function Contains($input, $test) {
        return strpos($input, $test) !== false;
    }

    /**
     * @param eString $input
     * @param eString $split_by 不可为空
     * @return array
     */
    public static function Split($input, $split_by = ',') {
        return explode($split_by, $input);
    }

    /**
     * @param array $input
     * @param eString $join_by
     * @return eString
     */
    public static function Join($input, $join_by = ',') {
        return implode($join_by, $input);
    }

    public static function GetFirstChar($input) {
        return mb_substr($input, 0, 1, 'UTF-8');
    }

    public static function GetLastChar($input) {
        return mb_substr($input, -1, 1, 'UTF-8');
    }

    public static function ToFirstCharUpperFormat($input) {
        $data = strtolower($input);
        $first = self::GetFirstChar($data);
        $result = strtoupper($first) . mb_substr($data, 1, NULL, 'UTF-8');
        return $result;
    }

}
