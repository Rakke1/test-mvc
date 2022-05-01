<?php

namespace Rakke1\TestMvc\Controllers;

use Rakke1\TestMvc\Controller;
use Rakke1\TestMvc\Models\TodoList;

class TodoController extends Controller
{
    public function new()
    {
        $todoModel = new TodoList();
        $todoModel->loadParams([
            'username' => $_POST['username'],
            'email'    => $_POST['email'],
            'todo'     => $_POST['todo'],
            'status'   => TodoList::$STATUS_NOT_DONE,
        ]);

        if ($todoModel->save()) {
            return json_encode(['status' => true]);
        }

        http_response_code(400);
        return json_encode(['status' => false]);
    }

    public function view()
    {
        return 'test view';
    }
}