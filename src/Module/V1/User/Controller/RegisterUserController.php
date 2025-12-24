<?php

namespace App\Module\V1\User\Controller;

use App\Module\V1\User\Service\RegisterUserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Exception\ValidationException;

class RegisterUserController
{

    public function __construct(private RegisterUserService $registerUserService) {}

    public function store(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (!is_array($data)) {
            throw new ValidationException('Invalid request body');
        }
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        }

        if (!empty($errors)) {
            throw new ValidationException('Email and password are required', $errors);
        }

        $this->registerUserService->register($data['email'], $data['password']);

        $response->getBody()->write(json_encode([
            "message" => "User registered succesfully!"
        ]));

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
