<?php

namespace Rakke1\TestMvc\Models;

use PDO;
use Rakke1\TestMvc\App;

class TodoList
{
    public static int $STATUS_NOT_DONE = 0;
    public static int $STATUS_DONE = 1;

    private static string $TABLE_NAME = 'todo_list';

    protected string $username;
    protected string $email;
    protected string $todo;
    protected int $status;
    protected bool $wasEditAdmin = false;

    public static function getTableName()
    {
        return self::$TABLE_NAME;
    }

    public static function getAll($limit = 3, $offset = 0): array
    {
        try {
            $tableName = self::$TABLE_NAME;
            $dbRequest = App::$app->db->prepare("SELECT * FROM $tableName LIMIT :limit OFFSET :offset");
            $dbRequest->bindParam(':limit', $limit);
            $dbRequest->bindParam(':offset', $offset);

            $dbRequest->execute();
            return $dbRequest->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException) {
            return [
                [
                    'username'         => 'test_username',
                    'email'            => 'test@test.test',
                    'todo'             => 'todo text',
                    'status'           => self::$STATUS_NOT_DONE,
                    'was_edit_admin'   => false,
                ],
                [
                    'username'         => 'test_username',
                    'email'            => 'test@test.test',
                    'todo'             => 'todo text',
                    'status'           => self::$STATUS_NOT_DONE,
                    'was_edit_admin'   => false,
                ],
                [
                    'username'         => 'test_username',
                    'email'            => 'test@test.test',
                    'todo'             => 'todo text',
                    'status'           => self::$STATUS_NOT_DONE,
                    'was_edit_admin'   => false,
                ],
            ];
        }
    }

    public static function countAll(): int
    {
        $tableName = self::$TABLE_NAME;
        $dbRequest = App::$app->db->query("SELECT COUNT(*) FROM $tableName");
        $row = $dbRequest->fetch(PDO::FETCH_ASSOC);
        return $row['COUNT(*)'] ?? 0;
    }

    public function loadParams(array $params): void
    {
        $this->username = $params['username'] ?? '';
        $this->email = $params['email'] ?? '';
        $this->todo = $params['todo'] ?? '';
        $this->status = $params['status'] ?? self::$STATUS_NOT_DONE;
    }

    public function save(): bool
    {
        $tableName = self::$TABLE_NAME;
        $sql = "INSERT INTO $tableName (username, email, todo, status, was_edit_admin) VALUES (?,?,?,?,?)";
        return App::$app->db->prepare($sql)->execute([
            $this->username,
            $this->email,
            $this->todo,
            $this->status,
            $this->wasEditAdmin,
        ]);
    }
}
