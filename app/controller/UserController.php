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
        $user = User::getByEmail($requestData['email']);

        if(!$user){
            return View::render('message', [
                'title' => 'Ошибка авторизации', 'text' => 'wrong email or password'
            ]);
        }

        $result = Auth::login($requestData['email'], $requestData['password']);

        if($result){
            return View::render('message', ['title' => 'Авторизация', 'text' => 'Вы успешно авторизированны']);
        }
        return View::render('message', [
            'title' => 'Ошибка авторизации',
            'text' => 'Во время авторизации произошла ошибка'
        ]);
    }

    public function registrationAction($urlArguments, $requestData): string
    {
        $password = $requestData['password'];

        if(strlen('password') < 4){
            return View::render('message', [
                'title' => 'Ошибка регистрации',
                'text' => 'Пароль слишком короткий'
            ]);
        }
        if($password !== $requestData['password-repeat']){
            return View::render('message', [
                'title' => 'Ошибка регистрации',
                'text' => 'Пароли не совпадают'
            ]);
        }

        try{
            $user = new User([
                'email' => $requestData['email'],
                'password' => $requestData['password'],
                'name' => $requestData['name'],
            ]);
            $user->save();

            Auth::authorize($user->id);

            return View::render('message', [
                'title' => 'Регистрация',
                'text' => 'Регистрация прошла успешно',
            ]);

        } catch (\Exeption $err) {
            return View::render('message', [
                'title' => 'Ошибка регистрации',
                'text' => 'Ошибка',
            ]);
        }
    }

    public function logoutAction(): string
    {
        Auth::logout();

        return View::render('message', [
            'title' => 'Выход',
            'text' => 'Вы успешно вышли из аккаунта',
        ]);
    }
}