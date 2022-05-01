<?php

namespace Rakke1\TestMvc\Controllers;

use Rakke1\TestMvc\Controller;
use Rakke1\TestMvc\Models\TodoList;
use Rakke1\TestMvc\Models\User;

class TodoController extends Controller
{
    public function new()
    {
        $userModel = new User();
        $user = $userModel->getByEmail($_POST['email']);
        if (!$user) {
            $userModel->loadParams([
                'username' => $_POST['username'],
                'email'    => $_POST['email'],
            ]);

            if (!$userModel->save()) {
                http_response_code(400);
                return json_encode(['status' => false]);
            }

            $user = $userModel->getByEmail($_POST['email']);
        }

        $todoModel = new TodoList();
        $todoModel->loadParams([
            'user_id'  => $user['ID'],
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