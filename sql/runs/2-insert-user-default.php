<?php

require_once __DIR__ . "/../connection.php";

$password = "123456";
$password = password_hash($password, PASSWORD_BCRYPT);
$name     = "Admin";
$email    = "admin@scoob.com";
$avatar   = null;

$stmt = $pdo->prepare(
    "INSERT INTO users (name, email, password, avatar) 
            VALUES (:name, :email, :password, :avatar)"
);

$stmt->execute([
    ':name'     => $name,
    ':email'    => $email,
    ':password' => $password,
    ':avatar'   => $avatar
]);

$pdo->exec($sql);