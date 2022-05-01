<?php

ini_set('display_errors',1);

use Rakke1\TestMvc\App;
use Rakke1\TestMvc\Route;
use Rakke1\TestMvc\Controllers\SiteController;
use Rakke1\TestMvc\Controllers\TodoController;

require_once __DIR__ . '/vendor/autoload.php';

$rootDir = dirname(__DIR__) . '/html';

$app = new App($rootDir);
$app->router->add(new Route('home', '/', [SiteController::class, 'home']));
$app->router->add(new Route('login', '/login', [SiteController::class, 'login']));
$app->router->add(new Route('newTodo', '/todo', [TodoController::class, 'new'], ['POST']));
$app->router->add(new Route('viewTodo', '/todo', [TodoController::class, 'view'], ['GET']));
$app->run();
