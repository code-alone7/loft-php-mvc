<?php

namespace Core;

class View extends AView
{
    public function __construct(string $templateDir)
    {
        $this->templateDir = $templateDir;
    }

    public function render(string $title, array $data = []): string
    {
        $titleParts = explode('.', $title);
        $fullPath = $this->templateDir;

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