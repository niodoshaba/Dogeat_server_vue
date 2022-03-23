<?php

namespace Bang\Lib;

use Exception;
use Models\ErrorCode;

/**
 * @author Bang
 */
class TextFile {

    public function __construct($path) {
        $this->Path = Path::Content($path);
    }

    private $Path;

    public function Read() {
        $path = ($this->Path);
        if (is_file($path)) {
            $file = $this->FileOpen($path, "r");
            $content = '';
            $length = filesize($path);
            if ($length > 0) {
                $content = $this->FileRead($file, filesize($path));
            }
            fclose($file);
            return $content;
        } else {
            throw new Exception('File not found!', 404);
        }
    }

    public function Write($content) {
        $path = ($this->Path);
        $file = $this->FileOpen($path, "w");
        fwrite($file, $content);
        fclose($file);
    }

    public function Append($content) {
        $path = ($this->Path);
        $file = $this->FileOpen($path, "a");
        fwrite($file, $content);
        fclose($file);
    }

    public function GetFileSize() {
        $size = filesize($this->Path);
        return $size;
    }

    public function GetFileSizeKB() {
        $size = $this->GetFileSize();
        return doubleval($size) / 1024.0;
    }

    public function GetFileSizeMB() {
        $size = $this->GetFileSizeKB();
        return $size / 1024.0;
    }

    public function GetFileSizeGB() {
        $size = $this->GetFileSizeMB();
        return $size / 1024.0;
    }

    public function CreateIfNotFound($default_content = '', $mode = 755) {
        $path = ($this->Path);
        if (!file_exists($path)) {
            $this->Write($default_content);
            $this->ChangeMode($mode);
        }
    }

    public function IsExist() {
        $result = file_exists($this->Path);
        return $result;
    }

    /**
     * 修改權限
     * @param string $mode EX:755
     */
    public function ChangeMode($mode = 755) {
        $oct_mode = octdec($mode);
        $path = ($this->Path);
        return chmod($path, $oct_mode);
    }

    private function FileOpen($full_file_path, $mode) {
        $file = fopen($full_file_path, $mode);
        if (false === $file) {
            throw new Exception("File open fail:{$full_file_path}", ErrorCode::UnKnownError);
        }
        return $file;
    }

    private function FileRead($file, $length) {
        $content = fread($file, $length);
        if (false === $content) {
            throw new Exception("File read fail:{$this->Path}", ErrorCode::UnKnownError);
        }
        return $content;
    }

}
