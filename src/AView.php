<?php

namespace Core;

abstract class AView implements IView
{
    protected string|null $templateDir = null;

    public abstract function __construct(string $templateDir);

    abstract public function render(string $title, array $data);
}