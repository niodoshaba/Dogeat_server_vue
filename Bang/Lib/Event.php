<?php

namespace Bang\Lib;

/*
 * 主要是要用來做為系統事件使用
 */

/**
 * 事件(Observer實作)
 * @author Bang
 */
class Event {

    /**
     * @var array 事件的多維陣列 => 回呼含式
     */
    protected static $Callbacks = array();

    /**
     * 註冊事件回呼
     * @param string $eventName 觸發事件名稱
     * @param mixed $callback EventCallback的實體或Lambda
     */
    public static function RegisterCallback($eventName, $callback) {
        if (!is_callable($callback)) {
            throw new \Exception("Invalid callback!");
        }

        $eventName = strtolower($eventName);
        self::$Callbacks[$eventName][] = $callback;
    }

    /**
     * 觸發事件
     * @param string $eventName 要觸發事件的名稱
     * @param mixed $data 要傳送給callback的資料
     */
    public static function Trigger($eventName, $data) {
        $eventName = strtolower($eventName);
        if (isset(self::$Callbacks[$eventName])) {
            foreach (self::$Callbacks[$eventName] as $callback) {
                $callback($data);
            }
        }
    }

}
