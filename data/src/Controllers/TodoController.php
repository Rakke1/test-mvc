<?php

namespace Rakke1\TestMvc\Controllers;

use Rakke1\TestMvc\Controller;
use Rakke1\TestMvc\Models\TodoList;
use Rakke1\TestMvc\Models\User;

class TodoController extends Controller
{
    public function createNew()
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

    public function setDone(int $id)
    {
        if ($this->isAdmin() === false) {
            http_response_code(403);
            return json_encode(['status' => false]);
        }

        $todoModel = new TodoList();
        $todo = $todoModel->getById($id);

        if (!$todo) {
            http_response_code(400);
            return json_encode(['status' => false]);
        }

        if ($todoModel->updateById($id, ['status' => TodoList::$STATUS_DONE])) {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function update(int $id)
    {
        if ($this->isAdmin() === false) {
            http_response_code(403);
            return json_encode(['status' => false]);
        }

        $todoModel = new TodoList();
        $todo = $todoModel->getById($id);
        $todoText = $_POST['todo'] ?? '';

        if (!$todo || !$todoText) {
            http_response_code(400);
            return json_encode(['status' => false]);
        }

        if ($todoModel->updateById($id, ['todo' => $todoText, 'was_edit_admin' => true])) {
            return json_encode(['status' => true]);
        }

        return json_encode(['status' => false]);
    }

    public function view(int $id)
    {

        $todoModel = new TodoList();
        $todo = $todoModel->getById($id);
        if (!$todo) {
            http_response_code(400);
            return json_encode(['status' => false]);
        }

        $userModel = new User();
        $user = $userModel->getById($todo['user_id']);
        $todo['username'] = $user['username'];
        $todo['email'] = $user['email'];

        return json_encode($todo);
    }
}