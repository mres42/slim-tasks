<?php

namespace App\Module\V1\Auth\Service;

use App\Module\V1\Auth\Repository\AuthRepository;

class AuthService
{
    private AuthRepository $authRepository;

    public function __construct() {
        $this->authRepository = new AuthRepository();
    }

    public function authenticate(array $data) {

    }
}