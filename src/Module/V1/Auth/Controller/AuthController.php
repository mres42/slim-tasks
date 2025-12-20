<?php

namespace App\Module\V1\Auth\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Module\V1\Auth\Service\AuthService;

class AuthController
{
    public function __construct(private AuthService $service) {}

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

            $auth = $this->service->authenticate($data);

            $res->getBody()->write(json_encode([
                "msg" => "Sucessful login!",
                "auth" => $auth
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
}
