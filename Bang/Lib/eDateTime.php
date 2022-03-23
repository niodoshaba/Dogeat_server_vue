<?php

namespace Bang\Lib;

use DateInterval;
use DateTime;

/**
 * @author Bang
 */
class eDateTime {

    function __construct($time = null) {
        if (null !== $time) {
            if ($time instanceof DateTime) {
                $this->datetime = $time;
            } else if (eString::IsNotNullOrSpace($time)) {
                $this->datetime = new DateTime($time);
            } else {
                $this->datetime = new DateTime();
            }
        } else {
            $this->datetime = new DateTime();
        }
    }

    public function GetTimeZone() {
        return $this->datetime->getTimezone();
    }

    public static function Create($year, $month, $day, $hour = '01', $minute = '01', $second = '01') {
        $format = 'Y-m-d H:i:s';
        $datetime = DateTime::createFromFormat($format, "{$year}-{$month}-{$day} {$hour}:{$minute}:{$second}");
        $result = new eDateTime($datetime);
        return $result;
    }

    /**
     * @param type $yyyymm
     * @return eDateTime
     */
    public static function CreateByYYYYmm($yyyymm) {
        $format = 'YmdHis';
        $datetime = DateTime::createFromFormat($format, "{$yyyymm}01000000");
        $result = new eDateTime($datetime);
        return $result;
    }

    /**
     * @var DateTime
     */
    private $datetime;

    /**
     * 與原本Datetime相同
     * @param string $format
     * @return string
     */
    public function Format($format) {
        return $this->datetime->format($format);
    }

    /**
     * @param int $count
     */
    public function AddSeconds($count) {
        $min_count = intval($count);
        if ($min_count < 0) {
            $this->datetime->modify("{$min_count} second");
        } else {
            $this->datetime->modify("+{$min_count} second");
        }
    }

    public function AddMinutes($count) {
        $min_count = intval($count);
        if ($min_count < 0) {
            $min_count = $min_count * -1;
            $this->datetime->sub(new DateInterval("PT{$min_count}M"));
        } else {
            $this->datetime->add(new DateInterval("PT{$min_count}M"));
        }
    }

    public function AddYear($count) {
        $day_count = intval($count);
        if ($day_count < 0) {
            return $this->SubYear($day_count * -1);
        } else {
            $this->datetime->add(new DateInterval("P{$day_count}Y"));
        }
    }

    public function SubYear($count) {
        $day_count = intval($count);
        if ($day_count < 0) {
            return $this->AddYear($day_count * -1);
        } else {
            $this->datetime->sub(new DateInterval("P{$day_count}Y"));
        }
    }

    public function AddMonth($count) {
        $day_count = intval($count);
        if ($day_count < 0) {
            return $this->SubMonth($day_count * -1);
        } else {
            $this->datetime->add(new DateInterval("P{$day_count}M"));
        }
    }

    private function SubMonth($count) {
        $day_count = intval($count);
        if ($day_count < 0) {
            return $this->AddMonth($day_count * -1);
        } else {
            $this->datetime->sub(new DateInterval("P{$day_count}M"));
        }
    }

    public function AddDay($count) {
        $day_count = intval($count);
        if ($day_count < 0) {
            return $this->SubDay($day_count * -1);
        } else {
            $this->datetime->add(new DateInterval("P{$day_count}D"));
        }
    }

    private function SubDay($count) {
        $day_count = intval($count);
        if ($day_count < 0) {
            return $this->AddDay($day_count * -1);
        } else {
            $this->datetime->sub(new DateInterval("P{$day_count}D"));
        }
    }

    public function ToDateTimeString() {
        return $this->datetime->format('Y-m-d H:i:s');
    }

    public function ToDateString() {
        return $this->datetime->format('Y-m-d');
    }

    public function ToYYmm() {
        return $this->datetime->format('ym');
    }

    public function ToYYYYmm() {
        return $this->datetime->format('Ym');
    }

    public function GetSecond() {
        return $this->datetime->format('s');
    }

    public function GetMinute() {
        return $this->datetime->format('i');
    }

    public function GetHour() {
        return $this->datetime->format('H');
    }

    public function GetDay() {
        return $this->datetime->format('d');
    }

    public function GetYear() {
        return $this->datetime->format('Y');
    }

    public function GetMonth() {
        return $this->datetime->format('m');
    }

    /**
     * @return eDateTime
     */
    public function GetFirstDateOfTheMonth() {
        $date_str = $this->Format('Y-m-') . '01';
        $datetime = new eDateTime($date_str);
        return $datetime;
    }

    public function GetLastMonthYYmm() {
        $datetime = $this->GetFirstDateOfTheMonth();
        $datetime->AddDay(-1);
        $result = $datetime->ToYYmm();
        $datetime->AddDay(1);
        return $result;
    }

    public function GetLastMonthYYYYmm() {
        $datetime = $this->GetFirstDateOfTheMonth();
        $datetime->AddDay(-1);
        $result = $datetime->ToYYYYmm();
        $datetime->AddDay(1);
        return $result;
    }

    public function ToTimestamp() {
        return $this->datetime->getTimestamp();
    }

    public function GetFirstDateOfTheWeek() {
        $datetime = new eDateTime($this->ToDateString());
        if ($datetime->GetWeekDay() != 0) {
            $days = $datetime->GetWeekDay();
            $datetime->AddDay((-1 * $days));
        }
        return $datetime->ToDateString();
    }

    public function GetWeekDay() {
        return intval($this->Format('w'));
    }

    public function GetMondayDateOfTheWeek() {
        $datetime = new eDateTime($this->ToDateString());
        if ($datetime->GetWeekDay() == 0) {
            $datetime->AddDay(-6);
        } else {
            $days = $datetime->GetWeekDay();
            $datetime->AddDay((-1 * $days) + 1);
        }

        return $datetime->ToDateString();
    }

    /**
     * @return eDateTime
     */
    public static function GetFirstDateOfThisMonth() {
        $datetime = new eDateTime('first day of this month');
        return $datetime;
    }

    /**
     * @return eDateTime
     */
    public static function GetYesterday() {
        $datetime = new eDateTime();
        $datetime->AddDay(-1);
        return $datetime;
    }

    /**
     * 取的當前時間的字串（格式：yyyy-MM-dd HH:mm:ss.SSSSSS）
     * @param int $point_to 秒數至小數點第幾位
     */
    public static function GetDateTimeWithMilliseconds($point_to = 6) {
        $t = microtime(true);
        $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
        $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
        $result = $d->format("Y-m-d H:i:s.u");
        if ($point_to >= 0 && $point_to < 6) {
            $result = substr($result, 0, 20 + $point_to);
        }
        return $result;
    }

    /**
     * @param type $timestamp
     * @return eDateTime
     */
    public static function CreateByTimestamp($timestamp) {
        $datetime = new DateTime();
        $datetime->setTimestamp($timestamp);
        $result = new eDateTime($datetime);
        return $result;
    }

    public static function GetMicroTimestamp($with_dot = true) {
        $result = str_pad(microtime(true), 15, '1');
        if (!$with_dot) {
            $result = eString::Replace($result, '.', '');
        }
        return $result;
    }

    public static function GetFromToDateStringList($from_date, $to_date) {
        if ($from_date > $to_date) {
            return array();
        }
        $datetime = new eDateTime($from_date);
        $date = $datetime->ToDateString();
        $result = array();
        while ($date <= $to_date) {
            $result[] = $date;
            $datetime->AddDay(1);
            $date = $datetime->ToDateString();
        }
        return $result;
    }

}
