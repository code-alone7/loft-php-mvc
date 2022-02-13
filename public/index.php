<?php
include_once '../src/config.php';
include_once '../vendor/autoload.php';
include_once '../database/eloquent/init.php';


//helper includes
include_once('../src/helpers/getPath.php');

use \Core\Application;

$app = new Application();

$app->run();