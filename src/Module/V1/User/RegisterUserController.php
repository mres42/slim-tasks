<?php

namespace App\Module\V1\User;

use App\Module\V1\User\RegisterUserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Exception\ValidationException;

class RegisterUserController
{
    // private RegisterUserService $registerUserService;

    public function __construct(
        private RegisterUserService $registerUserService
    ) {}
    // public function __construct()
    // {
    //     $this->registerUserService = new RegisterUserService();
    // }

    public function store(Request $req, Response $res): Response
    {
        $data = $req->getParsedBody();

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

        $res->getBody()->write(json_encode([
            "message" => "User registered succesfully!"
        ]));

        return $res->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
