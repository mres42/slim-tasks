<?php

namespace App\Module\V1\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    private AuthService $service;

    public function __construct(AuthService $service) {
        $this->service = $service;
    }

    public function login(Request $req, Response $res): Response
    {
        try {
            $data = $req->getParsedBody();

            if (!is_array($data)) {
                throw new \InvalidArgumentException('Invalid request body');
            }

            if (empty($data['email']) || empty($data['password'])) {
                throw new \InvalidArgumentException("Email and password required!");
            }

            $res->getBody()->write(json_encode([
                "msg" => "Sucessful login!"
            ]));

            return $res->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (\Throwable $e) {
            $res->getBody()->write(json_encode([
                "error" => $e->getMessage()
            ]));

            return $res->withHeader('Content-Type', 'application/json')
                ->withStatus(400);
        }
    }

    // public function me(Request $req, Response $res): Response
    // {
    //     $user = $req->getAttribute('user');
    //     $res->getBody()->write(json_encode($user));
    //     return $res->withHeader('Content-Type', 'application/json');
    // }
}
