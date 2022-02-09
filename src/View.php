<?php

namespace Core;

class View
{
    public static string $templateDir = TEMPLATE_DIR;


    public static function render(string $title, array $data = []): string
    {
        $titleParts = explode('.', $title);
        $fullPath = static::$templateDir;
        foreach ($titleParts as $part) {
            $fullPath .= DIRECTORY_SEPARATOR . $part;
        }
        $fullPath .= '.phtml';

        extract($data);
        ob_start();
        include $fullPath;
        return ob_get_clean();
    }
}