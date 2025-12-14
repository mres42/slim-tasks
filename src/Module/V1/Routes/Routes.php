<?php

namespace App\Module\V1\Routes;


use App\Module\V1\Auth\AuthController;
use App\Module\V1\User\RegisterUserController;

class Routes
{
    public static function routes($app)
    {

        $app->post('/login', [AuthController::class, 'login']);

        $app->post('/register', [RegisterUserController::class, 'store']);
    }
}
