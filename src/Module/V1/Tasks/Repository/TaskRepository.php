<?php

namespace App\Module\V1\Tasks\Repository;

use App\Database\DB;
use PDO;

class TaskRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getConnection();
    }

    public function getTasks(): array
    {
        $sql = "Select * FROM tasks";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            return [];
        }
        return $result;
    }
}