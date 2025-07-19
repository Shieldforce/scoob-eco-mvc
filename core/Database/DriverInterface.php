<?php

namespace ScoobEcoCore\Database;

use PDO;

abstract class DriverInterface
{
    protected static ?PDO $connection = null;
    protected function __construct() {}
    protected function __clone() {}
    protected function __wakeup() {}

    public abstract static function getInstance(): PDO;
}