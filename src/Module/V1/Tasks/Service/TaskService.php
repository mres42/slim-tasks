<?php

namespace App\Module\V1\Tasks\Service;

use App\Exception\DatabaseException;
use App\Module\V1\Tasks\Repository\TaskRepository;

class TaskService
{
    public function __construct(private TaskRepository $taskRepository) {}

    public function listTasks(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $results = $this->taskRepository->getTasks($perPage, $offset);
        $total = $this->taskRepository->countTasks();

        if (!$results) {
            throw new DatabaseException("Could not find any task entries in database.");
        }

       return [
           'total' => $total,
           'results' => $results
       ];
    }

    public function createTask(array $data): array
    {
        $taskExists = $this->taskRepository->getByTitle($data['title']);
        if ($taskExists > 0) {
            throw new DatabaseException("Task with that title already exists.");
        }
        $result = $this->taskRepository->create($data['title'], $data['description']);

        if (!$result) {
            throw new DatabaseException("Could not create task.");
        }

       return $result;
    }
}
