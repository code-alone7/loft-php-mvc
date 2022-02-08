<?php

namespace App\model;

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
        $db = Db::getInstance();
        $select = "SELECT * FROM users WHERE `name` = :email";
        $data = $db->fetchOne($select, __METHOD__, [
            ':email' => $email
        ]);

        if (!$data) {
            return null;
        }

        return new self($data);
    }
}