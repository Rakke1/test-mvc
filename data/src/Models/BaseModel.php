<?php

namespace Rakke1\TestMvc\Models;

use PDO;
use PDOStatement;
use Rakke1\TestMvc\App;

abstract class BaseModel
{
    abstract public static function getTableName(): string;

    protected function fetchOne(PDOStatement $preparedPdo)
    {
        try {
            $preparedPdo->execute();
            return $preparedPdo->fetch(PDO::FETCH_ASSOC);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }

        return false;
    }

    protected function fetchAll(PDOStatement $preparedPdo): bool|array
    {
        try {
            $preparedPdo->execute();
            return $preparedPdo->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }

        return false;
    }

    protected function prepareSelect(
        array $whereParams = [],
        ?int $limit = null,
        ?int $offset = null): PDOStatement
    {
        $tableName = $this::getTableName();
        $query = "SELECT * FROM $tableName";
        $notEmptyWhereParams = empty($whereParams) === false;

        if ($notEmptyWhereParams) {
            $query .= ' WHERE';

            foreach ($whereParams as $key => $param) {
                $query .= " $key=:$key";
            }
        }

        if ($limit) {
            $query .= " LIMIT $limit";
        }

        if ($offset) {
            $query .= " OFFSET $offset";
        }

        $preparedPdo = App::$app->db->prepare($query);
        if ($notEmptyWhereParams) {
            foreach ($whereParams as $key => $param) {
                $preparedPdo->bindParam(":$key", $param);
            }
        }

        return $preparedPdo;
    }

    public function countAll(): int
    {
        $tableName = $this::getTableName();
        $preparedPdo = App::$app->db->prepare("SELECT COUNT(*) FROM $tableName");
        $row = $this->fetchOne($preparedPdo);
        return $row['COUNT(*)'] ?? 0;
    }

    protected function saveOne(array $params): bool
    {
        $tableName = $this::getTableName();
        $paramKeys = implode(',', array_keys($params));
        $paramValues = array_values($params);
        $paramValueReplacement = implode(',', array_fill(0, count($params), '?'));
        $sql = "INSERT INTO $tableName ($paramKeys) VALUES ($paramValueReplacement)";
        return App::$app->db->prepare($sql)->execute($paramValues);
    }
}