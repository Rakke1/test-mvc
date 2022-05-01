<?php

use Rakke1\TestMvc\App;
use Rakke1\TestMvc\Models\TodoList;
use Rakke1\TestMvc\Models\User;

require_once __DIR__.'/vendor/autoload.php';

$app = new App(dirname(__DIR__) . '/html');

function createUserTable(PDO $db): void
{
    $todoListTable = User::getTableName();
    $todoListSql =<<<EOF
            CREATE TABLE $todoListTable
            (
                ID             INTEGER      PRIMARY KEY AUTOINCREMENT,
                username       CHAR(255)    NOT NULL,
                email          CHAR(64)     NOT NULL,
                password       CHAR(64)     NOT NULL,
                role           INTEGER(1)   NOT NULL
            );
EOF;

    try {
        $response = $db->exec($todoListSql);
        if($response === false){
            echo print_r($db->errorInfo(), true);
        } else {
            echo "User table created successfully</br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function createTodoListTable(PDO $db): void
{
    $todoListTable = TodoList::getTableName();
    $userTable = User::getTableName();
    $todoListSql =<<<EOF
            CREATE TABLE $todoListTable
            (
                ID             INTEGER      PRIMARY KEY AUTOINCREMENT,
                user_id        INTEGER      NOT NULL,
                todo           TEXT         NOT NULL,
                status         INTEGER(1)   NOT NULL,
                was_edit_admin INTEGER(1)   NOT NULL,
                FOREIGN KEY (user_id) REFERENCES $userTable (id)
            );
            CREATE INDEX idx_user_id_todo_list ON $todoListTable (user_id);
EOF;

    try {
        $response = $db->exec($todoListSql);
        if($response === false){
            echo print_r($db->errorInfo(), true);
        } else {
            echo "TodoList table created successfully</br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

createUserTable($app->db);
createTodoListTable($app->db);