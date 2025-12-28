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

    public function create(string $title, string $description): array
    {
        $sql = "INSERT INTO tasks (title, description) VALUES (:title, :description)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('title', $title, PDO::PARAM_STR);
        $stmt->bindValue('description', $description, PDO::PARAM_STR);
        $stmt->execute();

        $id = (int) $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare(
            "SELECT id, title, description, created_at
            FROM tasks
            WHERE id = :id"
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByTitle(string $title): int
    {
        $sql = "SELECT COUNT(*) FROM tasks WHERE title = :title";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue('title', $title, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }
}
