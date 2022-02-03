<?php

namespace Core;

use Core\exceptions\RouteException;

class Route
{
    private array $routes = [];
    private $defaultAction = null;

    function add(string $method, string $url, string|callable $action)
    {
        if(is_string($action)){
            $exploded = explode('@', $action);
            $className = $exploded[0];
            $actionName = $exploded[1] ?? 'indexAction';
            $className = "\\App\\controller\\" . ucfirst($className);

            if(!class_exists($className)) throw new RouteException('non existing controller');

            $controller = new $className();

            $action = function() use ($controller, $actionName) { return $controller->{$actionName}(); };
        }

        $this->routes[] = [
            'method' => $method,
            'url' => $url,
            'action' => $action,
        ];
    }

    public function addDefault(callable|string $action)
    {
        $this->defaultAction = $action;
    }

    function getAction(string $method, string $url) : callable
    {
        $filtered = array_filter($this->routes, function ($el) use ($method) {
            return $el['method'] === $method;
        });

        $index = array_search($url, array_column($filtered, 'url'));

        if ($index === false) {
            if ($this->defaultAction === null) throw new RouteException("undefined route");
            else return $this->defaultAction;
        }

        return $this->routes[$index]['action'];
    }
}