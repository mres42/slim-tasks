<?php

namespace App\Module\V1\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    // private AuthService $service;

    // public function __construct(AuthService $service) {
    //     $this->service = $service;
    // }

    public function login(Request $req, Response $res): Response
    {
$res->getBody()->write("Hello world!");
return $res;

    }

    // public function me(Request $req, Response $res): Response
    // {
    //     $user = $req->getAttribute('user');
    //     $res->getBody()->write(json_encode($user));
    //     return $res->withHeader('Content-Type', 'application/json');
    // }
}
