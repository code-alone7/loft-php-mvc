<?php

namespace App\model;

class Message extends \Core\Model
{
    static protected array $fields = [
        'id' => [
            'type' => 'int',
            'primary_key' => true,
        ],
        'content' => [
            'type' => 'varchar'
        ],
        'user_id' => [
            'type' => 'int',
        ],
        'created_at' => [
            'type' => 'int',
        ],
    ];
}