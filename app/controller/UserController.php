<?php

namespace App\controller;

use App\model\User;
use Core\Auth;

class UserController extends \Core\Controller
{
    public function indexAction(): string
    {
        return 'user';
    }

    public function userPageAction($urlArguments): string
    {
        $user = User::getById($urlArguments[0]);
        return self::$view->render('user.user-page', ['user' => $user]);
    }

    public function loginPageAction(): string
    {
        return self::$view->render('user.login');
    }

    public function registrationPageAction(): string
    {
        return self::$view->render('user.registration');
    }

    public function loginAction($urlArguments, $requestData): string
    {
        $user = User::getByEmail($requestData['email']);

        if(!$user){
            return self::$view->render('message', [
                'title' => 'Ошибка авторизации', 'text' => 'wrong email or password'
            ]);
        }

        $result = Auth::login($requestData['email'], $requestData['password']);

        if($result){
            return self::$view->render('message', ['title' => 'Авторизация', 'text' => 'Вы успешно авторизированны']);
        }
        return self::$view->render('message', [
            'title' => 'Ошибка авторизации',
            'text' => 'Во время авторизации произошла ошибка'
        ]);
    }

    public function registrationAction($urlArguments, $requestData): string
    {
        $password = $requestData['password'];

        if(strlen('password') < 4){
            return self::$view->render('message', [
                'title' => 'Ошибка регистрации',
                'text' => 'Пароль слишком короткий'
            ]);
        }
        if($password !== $requestData['password-repeat']){
            return self::$view->render('message', [
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

            Auth::authorize($user);

            return self::$view->render('message', [
                'title' => 'Регистрация',
                'text' => 'Регистрация прошла успешно',
            ]);

        } catch (\Exeption $err) {
            return self::$view->render('message', [
                'title' => 'Ошибка регистрации',
                'text' => 'Ошибка',
            ]);
        }
    }

    public function logoutAction(): string
    {
        Auth::logout();

        return self::$view->render('message', [
            'title' => 'Выход',
            'text' => 'Вы успешно вышли из аккаунта',
        ]);
    }
}