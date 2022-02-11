<?php

namespace App\controller;

use App\model\Message;
use Core\Auth;
use Core\View;

class MessageController extends \Core\Controller
{
    public function createPageAction()
    {
        return View::render('message.create');
    }

    public function createAction($urlArguments, $requestData, $files)
    {
        $message = new Message($requestData);
        $user = Auth::user();
        $image = $files['image'] ?? false;

        $message->user_id = $user->id;
        if($image && isset($image['tmp_name'])){
            $type = explode('/', $image['type']);
            if($type[0] !== 'image') throw new \Exception('file must be an image');

            $imgName = rand(0, 1000000) . '.' . $type[1];
            $imgNewPath
                = ROOT_DIR . DIRECTORY_SEPARATOR
                . 'public'.DIRECTORY_SEPARATOR.'images' . DIRECTORY_SEPARATOR
                . $imgName;
            $imgPublicPath = 'images/'.$imgName;

            var_dump($imgPublicPath);

            move_uploaded_file($image['tmp_name'], $imgNewPath);
            $message->image = $imgPublicPath;
        }

        $message->save();

        return View::render('message', [
            'title' => 'Отправка сообщения',
            'text' => 'Отправка сообщения прошла успешно',
        ]);
    }

    public function deleteAction($urlArguments)
    {
        $message = Message::getById($urlArguments[0]);

        if($message){
            $message->delete();

            return View::render('message', [
                'title' => 'Удаление сообщения',
                'text' => 'Удаление прошло успешно',
            ]);
        }
        return View::render('message', [
            'title' => 'Удаление сообщения',
            'text' => 'Ошибка удаления',
        ]);
    }
}