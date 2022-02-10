<?php
include_once '../src/config.php';

include '../vendor/autoload.php';

//helper includes
include_once('../src/helpers/getPath.php');

use \Core\Application;

$app = new Application();

$app->run();