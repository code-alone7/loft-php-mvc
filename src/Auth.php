<?php

namespace Core;

use App\model\User;
use Core\exceptions\AuthException;

class Auth
{
    public static array $admins = [1];

    public static function login(string $email, string $password): bool
    {
        $user = User::getByEmail($email);

        if(!$user){
            throw new AuthException('wrong email or password');
        }

        if($user->password !== $password){
            throw new AuthException('wrong email or password');
        }

        static::authorize($user);
        return true;
    }

    public static function logout(){
        $_SESSION['user'] = null;
    }

    public static function authorize($user)
    {
        $_SESSION['user'] = $user;
    }

    public static function user(): User|null
    {
        if(array_key_exists('user', $_SESSION) && $_SESSION['user']){
            return $_SESSION['user'];
        }
        return null;
    }

    public static function isAdmin(): bool
    {
        if($_SESSION['user']){
            return in_array($_SESSION['user']->id, static::$admins);
        }
        return false;
    }

    public static function authorized(): bool
    {
        return isset($_SESSION['user']);
    }
}