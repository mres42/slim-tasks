<?php

namespace App\Module\V1\Tasks\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Module\V1\Tasks\Service\TaskService;

class TaskController
{
    public function __construct(private TaskService $taskService) {}

    public function index(Request $request, Response $response, array $args): Response
    {
        $results = $this->taskService->listTasks();

        $response->getBody()->write(json_encode([
            "msg" => "teste",
            "resultSet" => $results
        ]));

        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
