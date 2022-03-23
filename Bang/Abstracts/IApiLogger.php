<?php

namespace Bang\Abstracts;

use Exception;

/**
 * 
 * @author Bang
 */
interface IApiLogger {

    public function InitRequest($uri, $request);

    public function IsInitRequest();

    public function EndWithResponse($is_success, $response);

    public function Error(Exception $ex);
}
