<?php

require_once __DIR__. "/../connection.php";

$sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
        `name` varchar(191) NOT NULL,
        `email` varchar(191) NOT NULL,
        `avatar` varchar(191),
        `password` varchar(191) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);";

$pdo->exec($sql);