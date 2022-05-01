<?php

namespace Rakke1\TestMvc\Controllers;

use Rakke1\TestMvc\Controller;
use Rakke1\TestMvc\Models\TodoList;

class SiteController extends Controller
{
    public function home(int $pageNum = 1): string
    {
        $limit = 3;
        $offset = $limit * ($pageNum - 1);
        $todoListModel = new TodoList();
        $todoList = $todoListModel->getAll($limit, $offset);
        $todoNum = $todoListModel->countAll();
        $totalPageNum = (int)ceil((float)$todoNum / $limit);

        return $this->render('home', [
            'todoList'      => $todoList,
            'todoNum'       => $todoNum,
            'pageNum'       => $pageNum,
            'totalPageNum'  => $totalPageNum,
            'limit'         => $limit,
        ]);
    }

    public function login(): string
    {
        return $this->render('login');
    }
}
