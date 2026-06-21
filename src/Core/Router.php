<?php

namespace Src\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, callable $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, callable $action): void
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch(string $uri, string $method)
    {
        if (
            isset($this->routes[$method]) &&
            isset($this->routes[$method][$uri])
        ) {
            $result = call_user_func(
                $this->routes[$method][$uri]
            );

            return $result;
        }

        http_response_code(404);

        return [
            'error' => 'Route not found'
        ];
    }
}
?>
