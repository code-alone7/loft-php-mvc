<?php

namespace Core;

class View
{
    public string $templatePath = '';

    public function __construct(string $path)
    {
        $this->templatePath = $path;
    }

    public function render(string $title, array $data = []): string
    {
        extract($data);
        $titleParts = explode('.', $title);
        $fullPath = $this->templatePath;
        foreach ($titleParts as $part) {
            $fullPath .= DIRECTORY_SEPARATOR . $part;
        }
        $fullPath .= '.phtml';

        ob_start();
        include $fullPath;
        return ob_get_clean();
    }
}