<?php

namespace Models\RequestBag;

use Bang\Lib\Checker;
use Bang\Lib\eString;
use Bang\Lib\ORM;
use Exception;
use Models\ErrorCode;

/**
 * @author Bang
 */
class Base {

    protected function ThrowException($message, $code) {
        throw new Exception($message, $code);
    }

    public function ValidAllRequired() {
        $params = ORM::GetPropertiesName($this);
        foreach ($params as $param) {
            if (eString::IsNullOrSpace($this->{$param})) {
                $this->ThrowException("Miss the parameter '{$param}'!", ErrorCode::MissingParameter);
            }
        }
    }

    /**
     * @param array $array ex: array('Username','Password', ...)
     */
    public function ValidProperties($array) {
        foreach ($array as $value) {
            if (eString::IsNullOrSpace($this->{$value})) {
                $this->ThrowException("Miss the parameter '{$value}'!", ErrorCode::MissingParameter);
            }
        }
    }

    public function ValidPositive($param) {
        $test = $this->{$param};
        if (eString::IsNotNullOrSpace($test)) {
            $value = doubleval($test);
            if ($value < 0) {
                $this->ThrowException("The number must be positive！", ErrorCode::WrongFormat);
            }
        }
    }

    public function HasProperties($array) {
        foreach ($array as $value) {
            if (eString::IsNotNullOrSpace($this->{$value})) {
                return true;
            }
        }
        return false;
    }

    public function ValidIsBoolean($param) {
        $test = $this->{$param};
        if (eString::IsNotNullOrSpace($test)) {
            $value = intval($test);
            if ($value !== 0 && $value !== 1) {
                $this->ThrowException("The parameters '{$param}' must be 1 or 0!", ErrorCode::WrongFormat);
            }
        }
    }

    public function ValidIsDate($param) {
        $test = $this->{$param};
        if (eString::IsNotNullOrSpace($test) && !Checker::IsDate($test)) {
            $this->ThrowException("The parameters '{$param}' format is wrong!", ErrorCode::WrongFormat);
        }
    }

    public function ValidIsDateTime($param) {
        $test = $this->{$param};
        if (eString::IsNotNullOrSpace($test) && !Checker::IsDateTime($test)) {
            $this->ThrowException("The parameters '{$param}' format is wrong!", ErrorCode::WrongFormat);
        }
    }

}
