<?php

namespace App\model;

use Core\DB;
use App\model\User;

class Message extends \Core\Model
{
    protected static array $fields = [
        'id' => [
            'type' => 'int',
            'primary_key' => true,
        ],
        'content' => [
            'type' => 'varchar'
        ],
        'image' => [
            'type' => 'file',
            'is_not_required' => true,
        ],
        'user_id' => [
            'type' => 'int',
        ],
        'created_at' => [
            'type' => 'int',
        ],
    ];

    public static function get($num): array|false
    {
        $query = "SELECT * FROM messages ORDER BY created_at DESC LIMIT $num";

        $db = DB::getInstance();

        $messages = array_map(function($el){
            return new Message($el);
        }, $db->fetchAll($query, __METHOD__));

        return $messages;
    }

    public function user(): User
    {
        return User::getById($this->user_id);
    }
}