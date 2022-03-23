<?php

namespace Bang\Lib;

/**
 * @author Bang
 */
class KeyValueFileData {

    function __construct($file_path) {
        $this->text_file = new TextFile($file_path);
        if (!$this->text_file->IsExist()) {
            $default_content = json_encode(array());
            $this->text_file->CreateIfNotFound($default_content);
        }
        $this->array = null;
    }

    /**
     * @var TextFile 
     */
    private $text_file;
    private $array;

    public function AddKeyValue($key, $value) {
        $this->GetArray();
        $this->array[$key] = $value;
        $content = json_encode($this->array, JSON_PRETTY_PRINT);
        $this->text_file->Write($content);
    }

    public function GetArray() {
        if (null === $this->array) {
            $content = $this->text_file->Read();
            $this->array = json_decode($content, 1);
        }
        $result = $this->array;
        return $result;
    }

    public function IsExist($key) {
        $array = $this->GetArray();
        $result = isset($array[$key]);
        return $result;
    }

    private static $datas = array();

    /**
     * @param string $path
     * @return KeyValueFileData
     */
    public static function Current($path) {
        if (!isset(self::$datas[$path])) {
            self::$datas[$path] = new KeyValueFileData($path);
        }
        $result = self::$datas[$path];
        return $result;
    }
    
}
