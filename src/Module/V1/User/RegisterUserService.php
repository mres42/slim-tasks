<?php

namespace App\Module\V1\User;

use App\Module\V1\User\RegisterUserRepository;

class RegisterUserService
{
    private RegisterUserRepository $registerUserRepository;

    public function register(string $email, string $password): bool
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        return $this->registerUserRepository->insertNewUser($email, $passwordHash);
    }
}