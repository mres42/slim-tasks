<?php

namespace App\Module\V1\User\Service;

use App\Module\V1\User\Repository\RegisterUserRepository;
use App\Exception\DatabaseException;
use App\Exception\ValidationException;

class RegisterUserService
{
    public function __construct(private RegisterUserRepository $registerUserRepository) {}

    public function register(string $email, string $password): bool
    {
        $userExists = $this->registerUserRepository->userAlreadyExists($email);
        if ($userExists) {
            throw new ValidationException("User email already exists.", [
                "message" => "A user with that email already exists."
            ]);
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $register = $this->registerUserRepository->insertNewUser($email, $passwordHash);

        if (!$register) {
            throw new DatabaseException("Failed to register new user.");
        }

        return $register;
    }
}