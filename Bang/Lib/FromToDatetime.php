<?php

namespace Bang\Lib;

/**
 * @author Bang
 */
class FromToDatetime {

    function __construct($from_str, $to_str) {
        $this->from_str = $from_str;
        $this->to_str = $to_str;
        $this->from = new \DateTime($from_str);
        $this->to = new \DateTime($to_str);
    }

    /**
     * @var \Datetime
     */
    private $from;

    /**
     * @var \Datetime
     */
    private $to;
    private $from_str;
    private $to_str;

    public function GetFromStr() {
        return $this->from->format('Y-m-d H:i:s');
    }

    public function GetToStr() {
        return $this->to->format('Y-m-d H:i:s');
    }

    public function Valid($must_same_month = true) {
        if ($this->from > $this->to) {
            throw new \Exception('起始日期不可大于结束日期！', \Models\ErrorCode::WrongParameter);
        }

        if ($must_same_month) {
            $this->CheckSameMonth();
        }
    }

    public function CheckSameMonth() {
        $from_m = $this->from->format('m');
        $to_m = $this->to->format('m');
        if ($from_m !== $to_m) {
            throw new \Exception('起迄必须为相同月份！', \Models\ErrorCode::WrongParameter);
        }
    }

    public function GetFromYm() {
        return $this->from->format('ym');
    }

    public function GetToYm() {
        return $this->to->format('ym');
    }

}
