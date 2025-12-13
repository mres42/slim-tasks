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

    public function store(Request $req, Response $res)
    {
        $data = $req->getParsedBody();

        if (!is_array($data)) {
            throw new ValidationException('Invalid request body');
        }

        if (empty($data['email']) || empty($data['password'])) {
            throw new ValidationException("Email and password are required!", [
                "email" => empty($data['email']) ? "Email is required." : null,
                "password" => empty($data['password']) ? "Password is requried." : null
            ]);
        }

        $this->registerUserService->register($data['email'], $data['password']);

        $res->getBody()->write(json_encode([
            "message" => "User registered succesfully!"
        ]));

        return $res->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
