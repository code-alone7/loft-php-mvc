<?php

namespace App\controller;

class UserController extends \Core\Controller
{
    public function indexAction(): string
    {
        return 'user';
    }

    public function registration(): string
    {
        return 'registration';
    }

    public function login(): string
    {
        return 'login';
    }
}