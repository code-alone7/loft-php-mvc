<?php

namespace App\controller;

use App\model\Message;
use Core\Auth;
use Core\View;
use Intervention\Image\ImageManagerStatic as IImage;

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

            $iImage = IImage::make($image['tmp_name']);
            $iImage->resize($iImage->width() <= 500 ? 500 : 1500, null, function($img){
                    $img->aspectRatio();
                })
                ->text('WATERMARKED',$iImage->width()/2,$iImage->height()/2, function($font){
                    $font->file(ROOT_DIR . DIRECTORY_SEPARATOR . 'public/fonts/Rowdies-Bold.ttf');
                    $font->size(40);
                    $font->color([40, 40, 40, 0.5]);
                    $font->align('center');
                    $font->valign('center');
                    $font->angle(45);
                })
                ->save($imgNewPath);

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
            if($message->image){
                unlink($message->image);
            }
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