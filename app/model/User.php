<?php

namespace App\model;

class User extends \Core\Model
{
    static protected array $fields = [
        'id' => [
            'type' => 'int',
            'autoincrement' => true,
        ],
        'email' => [
            'type' => 'varchar'
        ],
        'password' => [
            'type' => 'varchar'
        ],
        'name' => [
            'type' => 'varchar'
        ],
        'created_at' => [
            'type' => 'int',
        ],
    ];
}