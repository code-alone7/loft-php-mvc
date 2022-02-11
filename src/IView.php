<?php

namespace Core;

interface IView
{
    function render(string $title, array $data);
}