<?php

namespace App\Core;

class Router {
    
    protected $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get($uri, $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch($uri, $method) {
        $uri = parse_url($uri, PHP_URL_PATH); 
        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];
            if (is_array($action)) {
                $controller = new $action[0]();
                call_user_func([$controller, $action[1]]);
            } elseif (is_callable($action)) {
                call_user_func($action);
            } else {
                http_response_code(500);
                echo "Ação inválida.";
            }
        } else {
            http_response_code(404);
            echo "Página não encontrada.";
        }
    }
}