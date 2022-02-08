<?php

namespace App\controller;

use App\model\User;
use Core\Auth;
use Core\View;

class UserController extends \Core\Controller
{
    public function indexAction(): string
    {
        return 'user';
    }

    public function userPageAction($urlArguments): string
    {
        $user = User::getById($urlArguments[0]);
        return View::render('user.user-page', ['user' => $user]);
    }

    public function loginPageAction(): string
    {
        return View::render('user.login');
    }

    public function registrationPageAction(): string
    {
        return View::render('user.registration');
    }

    public function loginAction($urlArguments, $requestData): string
    {
        $result = Auth::login($requestData['email'], $requestData['password']);

        if($result){
            return 'удача';
        }
        return 'провал';
    }

    public function registrationAction($urlArguments, $requestData): string
    {
        $password = $requestData['password'];

        if(strlen('password') < 4){
            return 'пароль слишком короткий';
        }
        if($password !== $requestData['password-repeat']){
            return 'пароли не совпадают';
        }

        try{
            var_dump($requestData);
            $user = new User([
                'email' => $requestData['email'],
                'password' => $requestData['password'],
                'name' => $requestData['name'],
            ]);
            $user->save();

            return 'удача';
        } catch (\Exeption $err) {
            return $err;
        }
    }
}