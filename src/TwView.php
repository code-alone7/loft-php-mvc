<?php

namespace Core;

use Twig\Loader\FilesystemLoader as TwLoader;
use Twig\Environment as TwEnv;

class TwView extends AView
{
    protected $twig;

    public function __construct(string $templateDir)
    {
        $this->templateDir = $templateDir;

        $loader = new TwLoader($templateDir);

        $this->twig = new TwEnv($loader, ['debug' => true]);
    }

    public function render(string $title, array $data = []): string
    {
        $titleParts = explode('.', $title);
        $fullPath = '';

        foreach ($titleParts as $part) {
            $fullPath .= DIRECTORY_SEPARATOR . $part;
        }
        $fullPath .= '.twig';

        return $this->twig->render($fullPath, [
            ...$data,
            'auth' => Auth::user(),
            'getPath' => function($path){ return getPath($path); },
            'isAdmin' => Auth::isAdmin(),
        ]);
    }
}