<?php

namespace ScoobEcoCore\Database;

use PDO;
use PDOException;
use ScoobEcoCore\Enum\ErrorType;
use ScoobEcoCore\Exception\ErrorHandler;
use ScoobEcoCore\Support\Config;

class MysqlDriver extends DriverInterface
{
    public static function getInstance(): PDO
    {
        $driver = Config::get("database.default_driver");

        try {
            if (is_null(self::$connection) && $driver == "mysql") {

                $name     = Config::get("database.{$driver}.name");
                $host     = Config::get("database.{$driver}.host");
                $user     = Config::get("database.{$driver}.user");
                $password = Config::get("database.{$driver}.password");
                $charset  = Config::get("database.{$driver}.charset");
                $port     = Config::get("database.{$driver}.port");

                $dns = "mysql:host=$host;port=$port;dbname=$name;charset=$charset";

                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$connection = new PDO($dns, $user, $password, $options);
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