<?php

namespace App\model;

class User extends \Core\Model
{
    static protected array $fields = [
        'id'=>'int',
        'email'=>'varchar',
        'password'=>'varchar',
        'name' =>'varchar',
        'created_at'=>'int',
    ];
}