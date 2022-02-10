<?php

namespace App\model;

use Core\DB;

class User extends \Core\Model
{
    protected static array $fields = [
        'id' => [
            'type' => 'int',
            'primary_key' => true,
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

    public static function getByEmail($email)
    {
        $db = DB::getInstance();
        $select = "SELECT * FROM users WHERE `email` = :email";
        $data = $db->fetchOne($select, __METHOD__, [
            ':email' => $email
        ]);

        if (!$data) {
            return null;
        }

        return new self($data);
    }
}