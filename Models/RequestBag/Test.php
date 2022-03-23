<?php

namespace Models\RequestBag;

/**
 * @author Bang
 */
class Test extends ChecksumBase {

    public $email;

    public function Valid() {
        parent::Valid();
        if (!\Bang\Lib\Checker::IsEmail($this->email)) {
            $this->ThrowException('Wrong Email Format', \Models\ErrorCode::WrongFormat);
        }
    }

    /**
     * @return \Models\RequestBag\Test
     */
    public static function GetFromQuery() {
        $bag = new Test();
        \Bang\Lib\Request::GetGet($bag);
        return $bag;
    }

}
