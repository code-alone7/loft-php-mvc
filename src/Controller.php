<?php

namespace Core;

abstract class Controller
{
    protected static IView $view;

    public static function setView(IView $view){
        self::$view = $view;
    }
}