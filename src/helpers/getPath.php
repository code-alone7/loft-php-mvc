<?php

function getPath($url){
    $host = $_SERVER["HTTP_HOST"] ?? $_SERVER["SERVER_NAME"];

    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';

    return $protocol . $host . DIRECTORY_SEPARATOR . $url;
}