<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$bootstrap = new Bootstrap($_SERVER['REQUEST_URI']);

header('Content-type: application/json');
echo json_encode($bootstrap->getResponse());