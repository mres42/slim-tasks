<?php

namespace App\Module\V1\Auth\Repository;

use App\Database\DB;
use PDO;
use App\Module\V1\User\Model\UserModel;

class AuthRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getConnection();
    }

    public function getUserByEmail(string $email): UserModel
    {
        $sql = "SELECT id, email FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return new UserModel();
        }

        return $this->mapRowToUser($row);
    }

    private function mapRowToUser(array $row): UserModel
    {
        $user = new UserModel();
        $user->setId($row["id"]);
        $user->setEmail($row["email"]);
        return $user;
    }
}