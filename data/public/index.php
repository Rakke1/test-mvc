<?php

ini_set('display_errors',1);
ini_set('session.save_path', realpath(dirname(__DIR__) . '/sessions'));
session_start();

use Rakke1\TestMvc\App;
use Rakke1\TestMvc\Route;
use Rakke1\TestMvc\Controllers\SiteController;
use Rakke1\TestMvc\Controllers\TodoController;

$rootDir = dirname(__DIR__);
require_once $rootDir . '/vendor/autoload.php';

$app = new App($rootDir);
$app->router->add(new Route('home', '/', [SiteController::class, 'home']));
$app->router->add(new Route('loginGet', '/login', [SiteController::class, 'loginGet'], ['GET']));
$app->router->add(new Route('loginPost', '/login', [SiteController::class, 'loginPost'], ['POST']));
$app->router->add(new Route('logout', '/logout', [SiteController::class, 'logoutPost'], ['POST']));
$app->router->add(new Route('newTodo', '/todo', [TodoController::class, 'createNew'], ['POST']));
$app->router->add(new Route('doneTodo', '/todoDone', [TodoController::class, 'setDone'], ['POST']));
$app->run();
