<?php

namespace App\model;

class Message extends \Core\Model
{
    static protected array $fields = [
        'id' => 'int',
        'content' => 'text',
        'user_id' => 'int',
        'created_at' => 'int',
    ];
}