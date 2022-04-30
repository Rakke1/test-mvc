<?php

namespace Rakke1\TestMvc\DB;

use \PDO;
use Rakke1\TestMvc\App;

class SQLiteConnection
{
    private PDO $pdo;

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return PDO
     */
    public function connect(): PDO
    {
        if (isset($this->pdo) === false) {
            $this->pdo = new PDO("sqlite:" . App::$ROOT_DIR . '/db/base.db');
        }
        return $this->pdo;
    }
}
