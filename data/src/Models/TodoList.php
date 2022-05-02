<?php

namespace Rakke1\TestMvc\Models;

use Rakke1\TestMvc\App;

class TodoList extends BaseModel
{
    public static int $STATUS_NOT_DONE = 0;
    public static int $STATUS_DONE = 1;
    public static array $SORTING_FIELDS = ['username', 'status', 'email'];
    public static array $SORTING_ORDERS = ['ASC', 'DESC'];

    protected string $todo;
    protected int $user_id;
    protected int $status;
    protected bool $wasEditAdmin = false;

    public static function getTableName(): string
    {
        return 'todo_list';
    }

    public function getAll($limit = 3, $offset = 0, ?string $sortBy = null, ?string $sortOrder = 'ASC'): array
    {
        $userTable = User::getTableName();
        $todoTable = self::getTableName();
        $query = "SELECT * FROM $todoTable td LEFT JOIN (SELECT ID as UID, username, email FROM $userTable) as u ON td.user_id=u.UID";
        $query .= " GROUP BY td.ID";
        if (in_array($sortBy, self::$SORTING_FIELDS, true)) {
            $query .= " ORDER BY $sortBy";
            if (in_array($sortOrder, self::$SORTING_ORDERS, true)) {
                $query .= " $sortOrder";
            }
        }
        $query .= " LIMIT $limit OFFSET $offset";
        $preparedPdo = App::$app->db->prepare($query);
        $todos = $this->fetchAll($preparedPdo);

        return is_array($todos) ? $todos : [];
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
