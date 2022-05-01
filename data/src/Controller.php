<?php

namespace Rakke1\TestMvc;

use Rakke1\TestMvc\Models\User;

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

    public function isAuth(): bool
    {
        $userId = $this->getUserId();
        return isset($userId);
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

    public function getUser()
    {
        $userId = $this->getUserId();
        if ($userId) {
            return (new User())->getById($userId);
        }

        return null;
    }

    public function isAdmin(): bool
    {
        $user = $this->getUser();
        $userRole = $user['role'] ?? null;
        return isset($userRole) && (int)$userRole === User::ROLE_ADMIN;
    }
}