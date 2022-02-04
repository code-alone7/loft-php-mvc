<?php

namespace App\controller;

use App\model\User;

class UserController extends \Core\Controller
{
    public function indexAction(): string
    {
        return 'user';
    }

    public function loginPageAction(): string
    {
        return 'loginPage';
    }

    public function registrationPageAction(): string
    {
        $user = new User([
            'email' => '1234',
            'password' => '1234',
            'name' => 'name',
        ]);

        return 'registrationPage';
    }
}