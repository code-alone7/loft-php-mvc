<?php
include_once '../src/config.php';

include '../vendor/autoload.php';

use \Core\Application;

$app = new Application();

$app->run();