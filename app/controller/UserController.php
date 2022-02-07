<?php

namespace App\controller;

use App\model\User;
use Core\View;

class UserController extends \Core\Controller
{
    public function indexAction(): string
    {
        return 'user';
    }

    public function loginPageAction(): string
    {
        return View::render('user.login');
    }

    public function registrationPageAction(): string
    {
        return View::render('user.registration');
    }
}