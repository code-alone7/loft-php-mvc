<?php

namespace App\controller;

use Core\View;

class HomeController extends \Core\Controller
{
    public function indexAction(): string
    {
        return View::render('home', ['blogs' => [1, 2, 3]]);
    }
}