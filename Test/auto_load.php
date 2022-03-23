<?php

require_once '../Config.php';
spl_autoload_register(function ($classname) {
    if ($classname == 'PHPUnit_Extensions_Story_TestCase' || $classname == 'Composer\Autoload\ClassLoader') {
        return;
    } else {
        $namespace_name = str_replace("\\", DIRECTORY_SEPARATOR, $classname);
        $namespace_path = Config::$Path . DIRECTORY_SEPARATOR . $namespace_name . '.php';
        if (file_exists($namespace_path)) {
            require_once($namespace_path);
        } else {
            throw new Exception("The class {$classname} was not found!");
        }
    }
});
