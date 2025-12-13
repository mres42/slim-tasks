<?php

namespace App\Module\V1\Auth;

use App\Module\V1\Auth\AuthRepository;

class AuthService
{
    private AuthRepository $authRepository;

    public function __construct() {
        $this->authRepository = new AuthRepository();
    }

    public function authenticate(array $data) {

    }
}