<?php

namespace ScoobEcoCore\Database;

use ScoobEcoCore\Support\Config;

class DB
{
    public static function connection()
    {
        $driver = Config::get("database.default_driver");

        if ($driver == "mysql") {
            return MysqlDriver::getInstance();
        }

        if ($driver == "sqlite") {
            return SqliteDriver::getInstance();
        }

        if ($driver == "sqlsrv") {
            return SqlSrvDriver::getInstance();
        }

        return null;
    }
}