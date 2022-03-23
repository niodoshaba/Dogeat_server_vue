<?php

namespace Bang\Lib;

/**
 * @author Bang
 */
class Math {

    public static function Get36CarryMap() {
        $map = array(
            0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4',
            5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9',
            10 => 'a', 11 => 'b', 12 => 'c', 13 => 'd', 14 => 'e',
            15 => 'f', 16 => 'g', 17 => 'h', 18 => 'i', 19 => 'j',
            20 => 'k', 21 => 'l', 22 => 'm', 23 => 'n', 24 => 'o',
            25 => 'p', 26 => 'q', 27 => 'r', 28 => 's', 29 => 't',
            30 => 'u', 31 => 'v', 32 => 'w', 33 => 'x', 34 => 'y',
            35 => 'z'
        );
        return $map;
    }

    public static function Get36CarryUnMap() {
        $map = array('0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4,
            '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9,
            'a' => 10, 'b' => 11, 'c' => 12, 'd' => 13, 'e' => 14,
            'f' => 15, 'g' => 16, 'h' => 17, 'i' => 18, 'j' => 19,
            'k' => 20, 'l' => 21, 'm' => 22, 'n' => 23, 'o' => 24,
            'p' => 25, 'q' => 26, 'r' => 27, 's' => 28, 't' => 29,
            'u' => 30, 'v' => 31, 'w' => 32, 'x' => 33, 'y' => 34,
            'z' => 35
        );
        return $map;
    }

    /**
     * @param int $n C n取r的n
     * @param int $r C n取r的r
     * @return int 结果计算值
     */
    public static function C($n, $r) {
        if ((!is_numeric($n)) || (!is_numeric($r))) {
            throw new \Exception('输入格式不正确！');
        }
        if ($r > $n) {
            throw new \Exception('C n取r r不可大于n！');
        }
        if (($n - $r) < $r) {
            return Math::C($n, ($n - $r));
        } else {
            $return = 1;
            for ($i = 0; $i < $r; $i++) {
                $return *= ($n - $i) / ($i + 1);
            }
            return $return;
        }
    }

    /**
     * @param int $n P n取r的n
     * @param int $r P n取r的r
     * @return int 结果计算值
     */
    public static function P($n, $r) {
        if ((!is_numeric($n)) || (!is_numeric($r))) {
            throw new \Exception('输入格式不正确！');
        }
        if ($r > $n) {
            throw new \Exception('P n取r r不可大于n！');
        }
        if ($r) {
            return $n * (Math::P($n - 1, $r - 1));
        } else {
            return 1;
        }
    }

    public static function To10CarryFrom36($carry_36_string) {
        $map = Math::Get36CarryUnMap();
        $chars = array_reverse(str_split(strtolower($carry_36_string)));
        $len = count($chars);
        if ($len > 5) {
            throw new \Exception('String length must less than 6.');
        }
        $sum = 0;
        for ($i = 0; $i < $len; $i++) {
            $char = $chars[$i];
            $value = $map[$char];
            if ($i > 0) {
                $value = pow(36, $i) * $value;
            }
            $sum += $value;
        }
        return $sum;
    }

    public static function To36Carry($int) {
        $result = "";
        $map = Math::Get36CarryMap();
        $floor = doubleval($int);
        do {
            $mod = intval(Math::Bcmod($floor, 36));
            $floor = floor($floor / 36);
            $result = $map[$mod] . $result;
        } while ($floor >= 36);
        $mod = $floor % 36;
        if ($mod > 0) {
            $result = $map[$mod] . $result;
        }
        return $result;
    }

    public static function Bcmod($x, $y) {
        if (function_exists('bcmod')) {
            return bcmod($x, $y);
        } else {
            $take = 5;
            $mod = '';
            do {
                $a = (int) $mod . substr($x, 0, $take);
                $x = substr($x, $take);
                $mod = $a % $y;
            } while (strlen($x));
            return (int) $mod;
        }
    }

    public static function Round($number, $decimals = 2) {
        $result = number_format($number, $decimals, '.', '');
        return $result;
    }

}
