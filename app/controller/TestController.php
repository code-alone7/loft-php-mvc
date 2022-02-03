<?php

namespace App\controller;

use Core\Controller;
use Core\View;

class TestController extends Controller
{
    public function indexAction(): string
    {
        return 'index';
    }

    public function oneAction(): string
    {
        return 'one';
    }

    public function twoAction(): string
    {
        return 'two';
    }

    public function threeAction(): string
    {
        $view = new View(ROOT_DIR.DIRECTORY_SEPARATOR.'app/view');

        return $view->render('test.three', ['test' => '1234']);
    }
}