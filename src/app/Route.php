<?php

namespace App;

use App\Exception\NotFoundException;

class Route
{

    private array $routes = [];

    public function get(string $uri, callable|array $action): self
    {
        return $this->register('get', $uri, $action);
    }

    public function post(string $uri, callable|array $action): self
    {
        return $this->register('post', $uri, $action);
    }

    private function register(string $request_method, string $uri, callable|array $action): self
    {
        $uri = explode('?', $uri)[0];

        $this->routes[$request_method][$uri] = $action;

        return $this;
    }

    public function resolve(string $request_method, string $uri)
    {
        $action = $this->routes[$request_method][$uri] ?? null;

        if(! $action){
            throw new NotFoundException();
        }

        if(is_callable($action)){
           return call_user_func($action);
        }

        if(is_array($action)){
            [$class, $method] = $action;
            return call_user_func_array([new $class(), $method], []);
        }

        throw new NotFoundException();
    }
}