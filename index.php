<?php

include 'System.php';

Bang\Lib\Request::GetGet($route = new Bang\MVC\Route());
$route->invoke();

