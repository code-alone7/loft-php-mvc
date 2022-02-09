<?php

namespace App\controller;

use Core\View;

class MessageController extends \Core\Controller
{
    public function createPageAction(){
        return View::render('message.create');
    }
}