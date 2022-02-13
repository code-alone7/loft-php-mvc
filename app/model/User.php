<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'email',
        'password',
        'name',
    ];

    public static function getByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}