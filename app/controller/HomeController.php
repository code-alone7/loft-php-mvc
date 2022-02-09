<?php

namespace App\controller;

use Core\View;
use App\model\Message;

class HomeController extends \Core\Controller
{
    public function indexAction(): string
    {
        $messages = Message::get(20);

        return View::render('home', ['messages' => $messages]);
    }
}