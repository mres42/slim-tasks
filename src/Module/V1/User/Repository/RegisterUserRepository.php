<?php

namespace App\Module\V1\User\Repository;

use App\Database\DB;
use PDO;

class RegisterUserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getConnection();
    }

    public function insertNewUser(string $email, string $passwordHash): bool
    {
        $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);

        // true or false
        return $stmt->execute();
    }

    public function userAlreadyExists(string $email): bool
    {
        $sql = "SELECT 1 FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // fetch() returns false if no row, or array if row exists
        return (bool) $stmt->fetch();
    }

}
