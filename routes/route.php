<?php

require_once '../../app/ErrorHandler.php';

class Router
{
    private $routes = [];

    private function addRoute($method, $path, $callback){
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function get($path, $callback){
        $this->addRoute('GET', $path, $callback);
    }

    public function post($path, $callback){
        $this->addRoute('POST', $path, $callback);
    }

    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                call_user_func($route['callback']);
                return;
            }
        }

        ErrorHandler::handle404();
    }
}
