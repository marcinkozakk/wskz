<?php

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});
error_reporting(E_ERROR | E_PARSE);

Console::main();