<?php

namespace App\Application\Middleware;

use App\Application\Security\JwtService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class JwtMiddleware implements MiddlewareInterface
{
    public function __construct(private JwtService $jwt) {}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $auth = $request->getHeaderLine('Authorization');

        if (!preg_match('/Bearer\s+(.*)$/i', $auth, $matches)) {
            return $this->unauthorized();
        }

        try {
            $decoded = $this->jwt->validate($matches[1]);
            $request = $request->withAttribute('user', $decoded->data);
        } catch (\Throwable $e) {
            return $this->unauthorized();
        }

        return $handler->handle($request);
    }

    private function unauthorized(): ResponseInterface
    {
        $response = new Response();
        $response->getBody()->write(json_encode(['error' => 'Unauthorized']));
        return $response
            ->withStatus(401)
            ->withHeader('Content-Type', 'application/json');
    }
}
