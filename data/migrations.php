<?php

use PDOException;
use Rakke1\TestMvc\App;
use Rakke1\TestMvc\Models\TodoList;

require_once __DIR__.'/vendor/autoload.php';

$app = new App(dirname(__DIR__) . '/html');

function createTodoListTable($db): void
{
    $todoListTable = TodoList::getTableName();
    $todoListSql =<<<EOF
            CREATE TABLE $todoListTable
            (
                ID             INTEGER      PRIMARY KEY AUTOINCREMENT,
                username       CHAR(255)    NOT NULL,
                email          CHAR(64)     NOT NULL,
                todo           TEXT         NOT NULL,
                status         INTEGER(1)   NOT NULL,
                was_edit_admin INTEGER(1)   NOT NULL
            );
EOF;

    try {
        $response = $db->exec($todoListSql);
        if($response === false){
            echo print_r($db->errorInfo(), true);
        } else {
            echo "Table created successfully\n";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

createTodoListTable($app->db);