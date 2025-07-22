<?php

try {

    $host    = '172.17.0.1';
    $db      = 'scoob_db';
    $user    = 'user';
    $pass    = 'pass';
    $charset = 'utf8mb4';
    $port    = '3306';
    $dsn     = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
    $pdo     = new PDO($dsn, $user, $pass);

    echo "Instrução SQL rodou com sucesso!\n";

} catch (PDOException $e) {
    echo "<pre>";
    var_dump($e);
    echo "</pre>";
}
