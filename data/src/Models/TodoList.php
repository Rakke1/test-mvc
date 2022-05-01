<?php

namespace Rakke1\TestMvc\Models;

class TodoList extends BaseModel
{
    public static int $STATUS_NOT_DONE = 0;
    public static int $STATUS_DONE = 1;

    protected string $todo;
    protected int $user_id;
    protected int $status;
    protected bool $wasEditAdmin = false;

    public static function getTableName(): string
    {
        return 'todo_list';
    }

    public function getAll($limit = 3, $offset = 0): array
    {
        $preparedPdo = $this->prepareSelect([], $limit, $offset);
        $todos = $this->fetchAll($preparedPdo);

        if (is_array($todos)) {
            $userModel = new User();
            foreach ($todos as &$todo) {
                $user = $userModel->getById($todo['user_id']);
                $todo['username'] = $user['username'];
                $todo['email'] = $user['email'];
            }

            return $todos;
        }

        return [];
    }

    public function getById(int $id)
    {
        $preparedPdo = $this->prepareSelect([
            'id' => $id,
        ]);

        return $this->fetchOne($preparedPdo);
    }

    public function loadParams(array $params): void
    {
        $this->user_id = $params['user_id'] ?? '';
        $this->todo = $params['todo'] ?? '';
        $this->status = $params['status'] ?? self::$STATUS_NOT_DONE;
    }

    public function save(): bool
    {
        return $this->saveOne([
            'user_id'        => $this->user_id,
            'todo'           => $this->todo,
            'status'         => $this->status,
            'was_edit_admin' => $this->wasEditAdmin
        ]);
    }

    public function updateById(int $id, array $params)
    {
        return $this->updateOne(['ID' => $id], $params);
    }
}
