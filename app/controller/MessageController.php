<?php

namespace App\controller;

use App\model\Message;
use Core\Auth;
use Core\View;

class MessageController extends \Core\Controller
{
    public function createPageAction(){
        return View::render('message.create');
    }

    public function createAction($urlArguments, $requestData){
        $message = new Message($requestData);
        $message->user_id = Auth::user()->id;
        $message->save();

        if($message->id){
            return View::render('message', [
                'title' => 'Отправка сообщения',
                'text' => 'Отправка сообщения прошла успешно',
            ]);
        } else {
            return View::render('message', [
                'title' => 'Отправка сообщения',
                'text' => 'Ошбика при отправки сообщения',
            ]);
        }
    }
}