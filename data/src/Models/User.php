<?php

namespace Rakke1\TestMvc\Models;

class User extends BaseModel
{
    public const ROLE_USER = 0;
    public const ROLE_ADMIN = 1;

    protected string $username;
    protected string $email;
    protected string $password;
    protected ?int $role;
    protected array $userCache;

    public function __construct()
    {
        $this->userCache = [];
    }

    public static function getTableName(): string
    {
        return 'user';
    }

    public function loadParams(array $params): void
    {
        $this->username = $params['username'] ?? '';
        $this->email = $params['email'] ?? '';
        $this->password = $params['password'] ?? '';
        $this->role = $params['role'] ?? null;
    }

    public function getById(int $id)
    {
        $preparedPdo = $this->prepareSelect([
            'id' => $id,
        ]);
        if (!isset($this->userCache[$id])) {
            $this->userCache[$id] = $this->fetchOne($preparedPdo);
        }

        return $this->userCache[$id];
    }

    public function getByUsername(string $username)
    {
        $preparedPdo = $this->prepareSelect([
            'username' => $username,
        ]);
        return $this->fetchOne($preparedPdo);
    }

    public function getByEmail(string $email)
    {
        $preparedPdo = $this->prepareSelect([
            'email' => $email,
        ]);
        return $this->fetchOne($preparedPdo);
    }

    public function getPassword(): string
    {
        if ($this->password) {
            return password_hash($this->password, PASSWORD_DEFAULT);
        }

        return password_hash($this->generatePassword(), PASSWORD_DEFAULT);
    }

    public function getRole(): int
    {
        return is_int($this->role) ? $this->role : self::ROLE_USER;
    }

    public function save(): bool
    {
        return $this->saveOne([
            'username'       => $this->username,
            'email'          => $this->email,
            'password'       => $this->getPassword(),
            'role'           => $this->getRole(),
        ]);
    }

    protected function generatePassword(): string
    {
        $comb = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $comb = str_shuffle($comb);
        return substr($comb,0,8);
    }
}