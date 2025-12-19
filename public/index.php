<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Exception\ApiException;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$container = require __DIR__ . '/../config/container.php';
AppFactory::setContainer($container);

$app = AppFactory::create();
// middleware to automatically parse request body
$app->addBodyParsingMiddleware();

// error middleware
$errorMiddleware = $app->addErrorMiddleware(
    false,   // displayErrorDetails (false in prod)
    true,   // logErrors
    true    // logErrorDetails
);

$errorMiddleware->setDefaultErrorHandler(
    function (Request $request, Throwable $exception) use ($app): Response {
        // log errors to terminal
        error_log($exception->getMessage());

        $response = $app->getResponseFactory()->createResponse();

        if ($exception instanceof ApiException) {
            $payload = [
                'error' => [
                    'message' => $exception->getMessage(),
                    'code'    => $exception->getErrorCode(),
                    'details' => $exception->getDetails(),
                ]
            ];

            $status = $exception->getStatusCode();
        } else {
            $payload = [
                'error' => [
                    'message' => 'Internal server error',
                    'code'    => 'internal_error'
                ]
            ];

            $status = 500;
        }

        $response->getBody()->write(json_encode($payload));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
);

(require __DIR__ . '/../config/routes.php')($app);

$app->run();
