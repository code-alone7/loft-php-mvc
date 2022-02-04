<?php

namespace App\controller;

class HomeController extends \Core\Controller
{
    public function indexAction(): string
    {
        return 'home page';
    }
}