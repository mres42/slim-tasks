<?php

namespace App\Module\V1\Routes;


use App\Module\V1\Auth\Controller\AuthController;
use App\Module\V1\User\Controller\RegisterUserController;
use App\Application\Middleware\JwtMiddleware;
use App\Module\V1\Tasks\Controller\TaskController;

class Routes
{
    public static function routes($app)
    {
        /**
         * use ->add([JwtMiddleware::class])
         * for auth in routes
         */

        $app->post('/login', [AuthController::class, 'login']);
        $app->post('/register', [RegisterUserController::class, 'store']);

        $app->get('/task/list', [TaskController::class, 'index'])->add(JwtMiddleware::class);
    }
}
