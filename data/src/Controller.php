<?php

namespace Rakke1\TestMvc;

class Controller
{
    public function render($view, $params = []): string
    {
        return App::$app->view->renderView($view, $params);
    }

    public function redirect($path)
    {
        header('Location: ' . $path);
        exit();
    }

    public function setUserId(string $user_id): void
    {
        $_SESSION['user_id'] = $user_id;
    }

    public function removeUserId(): void
    {
        unset($_SESSION['user_id']);
    }

    public function getUserId()
    {
        return $_SESSION['user_id'] ?? null;
    }
}