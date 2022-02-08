<?php

namespace Core;

use App\model\User;
use Core\exceptions\AuthException;

class Auth
{
    public static array $admins = [1];

    public static function addAdmin(int $id): bool
    {
        if(array_search($id, static::$admins)){
            static::$admins[] = $id;
            return true;
        }
        return false;
    }

    public static function removeAdmin($id): bool
    {
        $index = array_search($id, static::$admins);

        if($index){
            array_splice(static::$admins, $index, 1);
            return true;
        }
        return false;
    }

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
}