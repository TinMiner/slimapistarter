<?php

declare(strict_types=1);

namespace App;

use PDO;

class Database
{
    public function getConnection(): PDO
    {
        $pdo = new PDO('sqlite:../rest.db');

        return $pdo;
    }
}