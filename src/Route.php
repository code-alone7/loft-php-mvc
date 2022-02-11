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
            $className = "\\App\\controller\\" . $className;

            if(!class_exists($className)) throw new RouteException('non existing controller');

            $controller = new $className();

            $action = function(...$args) use ($controller, $actionName) { return $controller->{$actionName}(...$args); };
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
        // получение роутов определенного метода
        $filtered = array_filter($this->routes, function ($el) use ($method) {
            return strtolower($el['method']) === strtolower($method);
        });
        $urls = array_column($filtered, 'url');

        $urlArguments = [];
        $route = current(
            array_filter($filtered, function($el)use($url, &$urlArguments){
                $match = true;
                $explodedURL = explode('/', $url);
                $explodedEL = explode('/', $el['url']);

                foreach($explodedURL as $i => $urlPart){
                    if($explodedEL[$i] === '##') {
                        $urlArguments[] = $urlPart;
                        continue;
                    }
                    if($explodedEL[$i] !== $urlPart){
                        $match = false;
                        break;
                    }
                }
                return $match;
            })
        );

        if ($route === false) {
            if ($this->defaultAction === null) throw new RouteException("undefined route");
            else return $this->defaultAction;
        }


        /*if(!empty($_POST))
        {
            $post = $_POST;
        } else {
            $post = json_decode(file_get_contents('php://input'), true);
        }*/

        return function() use ($route, $urlArguments) {
            return $route["action"]($urlArguments, $_POST, $_FILES);
        };
    }
}