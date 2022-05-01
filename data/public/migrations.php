<?php

use Rakke1\TestMvc\App;
use Rakke1\TestMvc\Models\TodoList;
use Rakke1\TestMvc\Models\User;

$rootDir = dirname(__DIR__);
require_once $rootDir . '/vendor/autoload.php';
$app = new App($rootDir);
$dotenv = Dotenv\Dotenv::createImmutable($rootDir);
$dotenv->load();

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
            echo 'User table created successfully</br>';
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
            echo 'TodoList table created successfully</br>';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function addAdminUser(): void
{
    $user = new User();

    if ($user->getByUsername($_ENV['ADMIN'])) {
        echo 'Admin already added</br>';
        return;
    }

    $user->loadParams([
        'username' => $_ENV['ADMIN'],
        'email'    => $_ENV['ADMIN_EMAIL'],
        'password' => $_ENV['ADMIN_PASSWORD'],
        'role'     => User::ROLE_ADMIN,
    ]);
    if ($user->save()) {
        echo 'Admin added successfully</br>';
    } else {
        echo 'Admin not added!</br>';
    }
}

createUserTable($app->db);
createTodoListTable($app->db);
addAdminUser();