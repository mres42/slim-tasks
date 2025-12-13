<?php

namespace App\Module\V1\User;

class UserModel
{
    private string $email;
    private string $passwordHash;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPassword(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }
}
