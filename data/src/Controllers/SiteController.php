<?php

namespace Rakke1\TestMvc\Controllers;

use Rakke1\TestMvc\Controller;
use Rakke1\TestMvc\Models\TodoList;
use Rakke1\TestMvc\Models\User;

class SiteController extends Controller
{
    public function home(): string
    {
        $pageNum = (int) ($_GET['page'] ?? 1);
        $sortBy = (string) ($_GET['sortBy'] ?? '');
        $sortOrder = (string) ($_GET['sortOrder'] ?? '');
        $limit = 3;
        $offset = $limit * ($pageNum - 1);
        $todoListModel = new TodoList();
        $todoList = $todoListModel->getAll($limit, $offset, $sortBy, $sortOrder);
        $todoNum = $todoListModel->countAll();
        $totalPageNum = (int)ceil((float)$todoNum / $limit);
        $isAuth = $this->isAuth();
        $isAdmin = $this->isAdmin();

        return $this->render('home', [
            'todoList'      => $todoList,
            'todoNum'       => $todoNum,
            'pageNum'       => $pageNum,
            'totalPageNum'  => $totalPageNum,
            'limit'         => $limit,
            'isAuth'        => $isAuth,
            'isAdmin'       => $isAdmin,
        ]);
    }

    public function loginGet(): string
    {
        if ($this->getUserId()) {
            $this->redirect('/');
        }

        return $this->render('login');
    }

    public function loginPost(): string
    {
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            $this->redirect('/login');
        }
        $userModel = new User();
        $user = $userModel->getByUsername($_POST['username']);
        if (!$user) {
            return json_encode(['status' => false, 'message' => 'Неверный пароль или имя']);
        }

        if (!password_verify($_POST['password'], $user['password'])) {
            return json_encode(['status' => false, 'message' => 'Неверный пароль или имя']);
        }

        $this->setUserId($user['ID']);

        return json_encode(['status' => true]);
    }

    public function logoutPost()
    {
        $this->removeUserId();
        $this->redirect('/');
    }
}
