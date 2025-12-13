<?php

namespace App\Module\V1\Routes;


use App\Module\V1\Auth\AuthController;
use App\Module\V1\User\UserController;

class Routes
{
    public static function routes($app)
    {

        // Auth routes
        // $app->post('/v1/auth/login',   [AuthController::class, 'login']);
        // $app->get('/',   [AuthController::class, 'login']);
        $app->post('/login',   [AuthController::class, 'login']);

        // Task routes
    }
}
