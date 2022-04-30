<?php

namespace Rakke1\TestMvc;

use Rakke1\TestMvc\DB\SQLiteConnection;
use Rakke1\TestMvc\Exception\NotFoundException;

class App
{
    public static App $app;
    public static string $ROOT_DIR;
    public Router $router;
    public View $view;
    public \PDO $db;

    public function __construct(string $rootDir)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootDir;
        $this->router = new Router();
        $this->view = new View();
        $this->db = (new SQLiteConnection())->connect();
    }

    public function run(): void
    {
        try {
            $route = $this->router->matchFromPath($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
        } catch (NotFoundException) {
            header('HTTP/1.0 404 Not Found');
            exit();
        }

        $handler = $route->getHandler();
        $arguments = $route->getAttributes();
        $controllerName = $handler[0];
        $methodName = $handler[1] ?? '';

        $controller = new $controllerName();
        if (!is_callable($controller)) {
            $controller = [$controller, $methodName];
        }

        echo $controller(...array_values($arguments));
    }
}