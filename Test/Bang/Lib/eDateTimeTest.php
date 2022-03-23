<?php

use Bang\Lib\eDateTime;

require_once 'auto_load.php';

class eDateTimeTest extends PHPUnit_Framework_TestCase {

    public function test_for_cross_year() {
        $date1 = new eDateTime('2018-01-01');
        $date1->AddDay(-1);
        $this->assertEquals($date1->ToDateString(), '2017-12-31');
    }

    public function test_for_cross_month() {
        $date1 = new eDateTime('2018-03-01');
        $date1->AddDay(-1);
        $this->assertEquals($date1->ToDateString(), '2018-02-28');
    }

    public function test_get_week_first_date_is_monday() {
        $date1 = new eDateTime("2017-07-02");
        $date2 = new eDateTime("2017-07-13");
        $date3 = new eDateTime("2018-02-04");

        $result1 = $date1->GetMondayDateOfTheWeek();
        $result2 = $date2->GetMondayDateOfTheWeek();
        $result3 = $date3->GetMondayDateOfTheWeek();

        $this->assertEquals($result1, '2017-06-26');
        $this->assertEquals($result2, '2017-07-10');
        $this->assertEquals($result3, '2018-01-29');
    }

    public function test_get_week_day() {
        $date1 = new eDateTime("2017-07-02");
        $date2 = new eDateTime("2017-07-13");

        $result1 = $date1->GetWeekDay();
        $result2 = $date2->GetWeekDay();

        $this->assertEquals($result1, 0);
        $this->assertEquals($result2, 4);
    }

    public function testGetWeekfirstDate() {
        $date1 = new eDateTime("2017-03-28");
        $date2 = new eDateTime("2017-04-05");
        $date3 = new eDateTime("2018-02-04 16:47:03");

        $result1 = $date1->GetFirstDateOfTheWeek();
        $result2 = $date2->GetFirstDateOfTheWeek();
        $result3 = $date3->GetFirstDateOfTheWeek();

        $this->assertEquals($result3, '2018-02-04');
        $this->assertEquals($result1, '2017-03-26');
        $this->assertEquals($result2, '2017-04-02');
    }

    public function testAddSecond1() {
        $seconds = rand(10, 58);
        $datetime_str = "2016-06-30 12:00:{$seconds}";
        $datetime = new eDateTime($datetime_str);
        $datetime->AddSeconds(1);
        $result = $datetime->ToDateTimeString();
        $after_minutes = $seconds + 1;
        $this->assertEquals($result, "2016-06-30 12:00:{$after_minutes}");
    }

    public function testAddSecond2() {
        $datetime_str = "2016-06-30 12:00:00";
        $datetime = new eDateTime($datetime_str);
        $datetime->AddSeconds(-2);
        $result = $datetime->ToDateTimeString();

        $this->assertEquals($result, '2016-06-30 11:59:58');
    }

    public function testAddMinutes1() {
        $minutes = rand(10, 58);
        $datetime_str = "2016-06-30 12:{$minutes}:00";
        $datetime = new eDateTime($datetime_str);
        $datetime->AddMinutes(1);
        $result = $datetime->ToDateTimeString();
        $after_minutes = $minutes + 1;
        $this->assertEquals($result, "2016-06-30 12:{$after_minutes}:00");
    }

    public function testAddMinutes2() {
        $datetime_str = "2016-06-30 12:59:00";
        $datetime = new eDateTime($datetime_str);
        $datetime->AddMinutes(1);
        $result = $datetime->ToDateTimeString();

        $this->assertEquals($result, '2016-06-30 13:00:00');
    }

    public function testAddMinutes3() {
        $datetime_str = "2016-06-30 12:00:00";
        $datetime = new eDateTime($datetime_str);
        $datetime->AddMinutes(-1);
        $result = $datetime->ToDateTimeString();

        $this->assertEquals($result, '2016-06-30 11:59:00');
    }

    public function testGetAndSet() {
        $hour = rand(10, 23);
        $minite = rand(10, 59);
        $second = rand(10, 59);
        $datetime_str = "2016-06-30 $hour:$minite:$second";
        $datetime = new eDateTime($datetime_str);

        $this->assertEquals('2016-06-30', $datetime->ToDateString());
        $this->assertEquals($datetime_str, $datetime->ToDateTimeString());

        $datetime->AddDay(1);
        $this->assertEquals('2016-07-01', $datetime->ToDateString());

        $datetime->AddDay(-1);
        $this->assertEquals('2016-06-30', $datetime->ToDateString());

        $datetime->AddMonth(1);
        $this->assertEquals('2016-07-30', $datetime->ToDateString());

        $datetime->AddDay(1);
        $this->assertEquals('2016-07-31', $datetime->ToDateString());

        $datetime->AddMonth(-1);
        $this->assertEquals('2016-07-01', $datetime->ToDateString());

        $datetime->AddYear(1);
        $this->assertEquals('2017-07-01', $datetime->ToDateString());

        $datetime->AddMonth(1);
        $this->assertEquals('2017-08-01', $datetime->ToDateString());
    }

    public function testGetLastYYmm() {
        $datetime = new eDateTime('2018-03-30 00:00:00');
        $result = $datetime->GetLastMonthYYmm();
        $this->assertEquals($result, '1802');
    }

    public function testGetAndSet2() {
        $hour = rand(10, 23);
        $minite = rand(10, 59);
        $second = rand(10, 59);
        $datetime_str = "2017-02-14 $hour:$minite:$second";
        $datetime = new eDateTime($datetime_str);

        $datetime->AddDay(-30);
        $this->assertEquals('2017-01-15', $datetime->ToDateString());
    }

    public function testCreate() {
        $datetime_str = "2016-06-30 12:01:01";
        $datetime = new eDateTime($datetime_str);

        $datetime2 = eDateTime::Create($datetime->GetYear(), $datetime->GetMonth(), $datetime->GetDay(), $datetime->GetHour(), $datetime->GetMinute(), $datetime->GetSecond());
        $this->assertEquals($datetime2->ToDateTimeString(), $datetime->ToDateTimeString());
    }

    public function testCreateByYYYYmm() {
        $yyyymm = '201801';
        $datetime = eDateTime::CreateByYYYYmm($yyyymm);
        $this->assertEquals($datetime->ToDateString(), '2018-01-01');

        $datetime->AddMonth(-1);
        $this->assertEquals($datetime->ToDateString(), '2017-12-01');
    }

}
