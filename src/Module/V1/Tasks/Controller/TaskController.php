<?php

namespace App\Module\V1\Tasks\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Module\V1\Tasks\Service\TaskService;
use App\Exception\ValidationException;
use Symfony\Component\Config\Definition\BaseNode;

class TaskController
{
    public function __construct(private TaskService $taskService) {}

    public function index(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getQueryParams();

            $page = max(1, (int) ($data['page'] ?? 1));
            $perPage = min(50, max(1, (int) ($data['perPage'] ?? 10)));
            
            $results = $this->taskService->listTasks($page, $perPage);

            $response->getBody()->write(json_encode([
                'page' => $page,
                'parPage' => $perPage,
                'total' => $results['total'],
                'results' => $results['results']
            ]));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode([
                "error" => $e->getMessage()
            ]));

            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();
            
            if (!is_array($data)) {
                throw new ValidationException('Invalid request body');
            }
            $errors = [];

            if (empty($data['title'])) {
                $errors['title'] = 'Title is required';
            }

            if (empty($data['description'])) {
                $errors['description'] = 'Description is required.';
            }

            if (!empty($errors)) {
                throw new ValidationException('Task title and description are required.', $errors);
            }

            $result = $this->taskService->createTask($data);

            $response->getBody()->write(json_encode([
                'status' => 'success',
                'id' => $result['id'],
                'title' => $result['title'],
                'description' => $result['description'],
            ]));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode([
                "error" => $e->getMessage()
            ]));

            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        try {
            if (!isset($args['id'])) {
                throw new ValidationException('Invalid id argument.');
            }

            $data = $request->getParsedBody();

            if (!is_array($data)) {
                throw new ValidationException('Invalid request body');
            }
            
            $title = isset($data['title']) ? trim($data['title']) : null;
            $description = isset($data['description']) ? trim($data['description']) : null;

            $title = $title === '' ? null : $title;
            $description = $description === '' ? null : $description;

            if ($title === null && $description === null) {
                throw new ValidationException('Title or description required.');
            }

            $result = $this->taskService->updateTask((int)$args['id'], $title, $description);

            $response->getBody()->write(json_encode([
                'status' => 'success',
                'updatedTask' => [
                    'id' => $result['id'],
                    'title' => $result['title'],
                    'description' => $result['description'],
                ]
            ]));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode([
                "error" => $e->getMessage()
            ]));

            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        try {
            if (!isset($args['id'])) {
                throw new ValidationException('Invalid id argument.');
            }


            $result = $this->taskService->deleteTask((int)$args['id']);

            $response->getBody()->write(json_encode([
                'status' => 'success',
                'message' => 'Task deleted successfully!'
            ]));

            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Throwable $e) {
            $response->getBody()->write(json_encode([
                "error" => $e->getMessage()
            ]));

            return $response->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }
}
