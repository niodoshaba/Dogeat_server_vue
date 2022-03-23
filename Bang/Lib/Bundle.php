<?php

namespace Bang\Lib;

use Bang\Lib\eString;
use Bang\Lib\Url;
use Bang\Lib\Path;

/**
 * @author Bang
 */
class Bundle {

    public static function Js($file_name, $js_files_array) {
        if (eString::IsNullOrSpace($file_name) && isset($js_files_array[0])) {
            $file_name = $js_files_array[0];
        }
        foreach ($js_files_array as $value) {
            $script_url = Url::Content($value);
            $echo_content = "<script src='{$script_url}'></script>";
            echo $echo_content;
        }
    }

    public static function Css($file_name, $css_files_array) {
        if (eString::IsNullOrSpace($file_name) && isset($css_files_array[0])) {
            $file_name = $css_files_array[0];
        }
        foreach ($css_files_array as $value) {
            $css_url = Url::Content($value);
            $echo_content = "<link href='{$css_url}' rel='stylesheet' type='text/css'/>";
            echo $echo_content;
        }
    }

    public static function PHP($file_name, $php_files_array) {
        if (eString::IsNullOrSpace($file_name) && isset($php_files_array[0])) {
            $file_name = $php_files_array[0];
        }
        foreach ($php_files_array as $value) {
            $path = Path::Content($value);
            require $path;
        }
    }

}
