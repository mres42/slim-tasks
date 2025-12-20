<?php

namespace App\Module\V1\Routes;


use App\Module\V1\Auth\Controller\AuthController;
use App\Module\V1\User\Controller\RegisterUserController;
use App\Application\Middleware\JwtMiddleware;

class Routes
{
    public static function routes($app)
    {

        // $app->post('/login', [AuthController::class, 'login']);
        $app->post('/login', [AuthController::class, 'login']);


        // $app->post('/register', RegisterUserController::class, 'store')->add(JwtMiddleware::class);
        $app->post('/register', [RegisterUserController::class, 'store']);
        // $app->post('/register', [RegisterUserController::class, 'store']);
    }
}
