<?php

namespace Core;

use Core\Route;

class Application
{
    private Route $route;

    public function __construct()
    {
        $this->route = new Route();
    }

    function run()
    {

        try {
            $this->setRoutes();
            $url = parse_url($_SERVER['REQUEST_URI']);
            echo $this->route->getAction('get', $url['path'])();
        } catch (\Exception $e) {
            echo '<pre>';
            echo $e->getMessage();
            echo '</pre>';
        }
    }

    function setRoutes()
    {
        $this->route->addDefault(function(){ return 'error 404'; });

        $this->route->add('get', '/', function(){
            return 'home';
        });
        $this->route->add('get', '/test/one', function(){
            return 'one';
        });
        $this->route->add('get', '/test/two', 'TestController@twoAction');
        $this->route->add('get', '/test/three', 'TestController@threeAction');
        $this->route->add('get', '/test/index', 'TestController');
    }
}