<?php

namespace ScoobEcoCore\Database;

use ScoobEcoCore\Database\Mysql\DBx;
use ScoobEcoCore\Support\Config;

class DB
{
    use DBx;

    public static         $connection = null;
    public static string  $driver;
    private static string $table;

    public function __construct()
    {

        self::$driver = Config::get("database.default_driver");

        if (self::$driver == "mysql") {
            self::$connection = MysqlDriver::getInstance();
        }

        if (self::$driver == "sqlite") {
            self::$connection = SqliteDriver::getInstance();
        }

        if (self::$driver == "sqlsrv") {
            self::$connection = SqlSrvDriver::getInstance();
        }
    }
}