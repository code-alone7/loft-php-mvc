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
            echo $this->route->getAction($_SERVER['REQUEST_METHOD'], $url['path'])();
        } catch (\Exception $e) {
            echo '<pre>';
            echo $e->getMessage();
            echo '</pre>';
        }
    }

    function setRoutes()
    {
        $this->route->addDefault(function(){ return 'error 404'; });
        $this->route->add('get', '/', 'HomeController');

        // user routes
        $this->route->add('get', '/user', 'UserController@indexAction');
        $this->route->add('get', '/login', 'UserController@loginPageAction');
        $this->route->add('get', '/registration', 'UserController@registrationPageAction');
    }
}