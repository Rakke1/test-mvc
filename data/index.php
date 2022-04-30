<?php

ini_set('display_errors',1);

use Rakke1\TestMvc\App;
use Rakke1\TestMvc\Route;
use Rakke1\TestMvc\Controllers\IndexController;

require_once __DIR__ . '/vendor/autoload.php';

$rootDir = dirname(__DIR__) . '/html';

$app = new App($rootDir);
$app->router->add(new Route('home', '/', [IndexController::class, 'home']));
$app->run();