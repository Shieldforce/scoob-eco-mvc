<?php

namespace ScoobEcoCore\Database\Mysql;

use PDO;

trait DBx
{
    public function table(string $table)
    {
        self::$table = $table;

        return $this;
    }

    public function get()
    {
        $conn = self::$connection;

        $table = self::$table;

        $sql = "SELECT * FROM `{$table}`";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function first()
    {
        $conn = self::$connection;

        $table = self::$table;

        $sql = "SELECT * FROM `{$table}` LIMIT 1";

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? (object)$result[0] : null;
    }

    public function find($id)
    {
        $conn = self::$connection;

        $table = self::$table;

        $sql = "SELECT * FROM `{$table}` WHERE id = ? LIMIT 1";

        $stmt = $conn->prepare($sql);

        $stmt->execute([$id]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? (object)$result[0] : null;
    }

}