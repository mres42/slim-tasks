<?php
$dsn = "mysql:host=127.0.0.1;dbname=slim_tasks;charset=utf8mb4";
$user = "root";
$pass = "minhasenha";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "Connected!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
