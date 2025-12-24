<?php

namespace App\Module\V1\Tasks\Service;

use App\Exception\DatabaseException;
use App\Module\V1\Tasks\Repository\TaskRepository;

class TaskService
{
    public function __construct(private TaskRepository $taskRepository) {}

    public function listTasks(): array
    {
       $results = $this->taskRepository->getTasks();

        if (!$results) {
            throw new DatabaseException("Could not find any task entries in database.");
        }

       return $results;
    }
}