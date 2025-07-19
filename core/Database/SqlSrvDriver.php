<?php

namespace ScoobEcoCore\Database;

use PDO;
use PDOException;
use ScoobEcoCore\Enum\ErrorType;
use ScoobEcoCore\Exception\ErrorHandler;
use ScoobEcoCore\Support\Config;

class SqlSrvDriver extends DriverInterface
{
    public static function getInstance(): PDO
    {
        $driver = Config::get("database.default_driver");

        try {
            if (is_null(self::$connection) && $driver == "sqlsrv") {

                throw new PDOException("Sql server driver not configured.");

            }
        } catch (PDOException $e) {
            ErrorHandler::handle(
                $e,
                ErrorType::fromCodeOrDefault($e->getCode()),
            );
        }

        return self::$connection;
    }

}