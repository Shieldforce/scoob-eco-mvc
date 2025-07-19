<?php

return [
    "default_driver" => env("DB_DRIVER", "mysql"),

    "mysql" => [
        "driver"   => env("DB_DRIVER", 'mysql'),
        "name"     => env("DB_NAME", 'scoob_db'),
        "host"     => env("DB_HOST", 'localhost'),
        "user"     => env("DB_USER", 'scoob_user'),
        "password" => env("DB_PASSWORD", 'scoob_password'),
        "charset"  => env("DB_CHARSET", 'utf8mb4'),
        "port"     => env("DB_PORT", '3306'),
    ]
];