<?php

namespace Bang\Lib;

/**
 * @author Bang
 */
class ListResult {

    function __construct($Datas, $TotalItems, $TotalPages) {
        $this->Datas = $Datas;
        $this->TotalItems = $TotalItems;
        $this->TotalPages = $TotalPages;
    }

    public $Datas;
    public $TotalItems;
    public $TotalPages;

    /**
     * @param ListResult $obj
     * @return ListResult
     */
    public static function AsType(ListResult $obj){
        return $obj;
    }
    
}
