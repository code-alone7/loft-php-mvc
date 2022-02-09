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
            session_start();
            $this->setRoutes();
            $url = parse_url($_SERVER['REQUEST_URI']);
            echo $this->route->getAction($_SERVER['REQUEST_METHOD'], $url['path'])([1,2,3],[1,2,3]);
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
        $this->route->add('get', '/user/##', 'UserController@userPageAction');
        $this->route->add('get', '/login', 'UserController@loginPageAction');
        $this->route->add('get', '/registration', 'UserController@registrationPageAction');

        $this->route->add('post', '/login', 'UserController@loginAction');
        $this->route->add('post', '/registration', 'UserController@registrationAction');
        $this->route->add('get', '/logout', 'UserController@logoutAction');

        // message routes

        $this->route->add('get', '/message/create', 'MessageController@createPageAction');
        $this->route->add('post', '/message/create', 'MessageController@createAction');
    }
}