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

    public function getTasks(int $limit, int $offset): array
    {
        $sql = "Select * FROM tasks ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$result) {
            return [];
        }
        return $result;
    }

    public function countTasks(): int
    {
        $sql = "SELECT COUNT(*) FROM tasks";
        return (int) $this->pdo->query($sql)->fetchColumn();
    }
}
