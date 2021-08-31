<?php

class Bootstrap
{
    public array $method;
    public array $params = [];

    public function __construct($currentRoute)
    {
        $routes = require 'routes.php';
        $params = [];

        foreach ($routes as $route => $method) {
            if (preg_match($route, $currentRoute, $params)) {
                $this->method = $method;
                $this->params = array_slice($params, 1);
                break;
            }
        }
    }

    public function getResponse()
    {
        try {
            return call_user_func($this->method, ...$this->params);
        } catch (Error $e) {
            http_response_code(404);
            exit('Error 404 Not Found');
        }
    }
}