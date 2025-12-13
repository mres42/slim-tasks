<?php

namespace App\Module\V1\User;

class RegisterUserRepository
{
    public function insertNewUser(string $email, string $passwordHash): bool
    {
        return true;
    }
}