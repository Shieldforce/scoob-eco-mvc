<?php

namespace ScoobEcoCore\Enum;

enum ErrorType : int
{
    // PHP core error types
    case E_ERROR             = 1;
    case E_WARNING           = 2;
    case E_PARSE             = 4;
    case E_NOTICE            = 8;
    case E_CORE_ERROR        = 16;
    case E_CORE_WARNING      = 32;
    case E_COMPILE_ERROR     = 64;
    case E_COMPILE_WARNING   = 128;
    case E_USER_ERROR        = 256;
    case E_USER_WARNING      = 512;
    case E_USER_NOTICE       = 1024;
    case E_STRICT            = 2048;
    case E_RECOVERABLE_ERROR = 4096;
    case E_DEPRECATED        = 8192;
    case E_USER_DEPRECATED   = 16384;

    // Custom application error types
    case GENERIC_ERROR       = 0;
    case UNKNOWN_DATABASE    = 1049;
    case DATABASE_ERROR      = 10005;
    case VALIDATION_ERROR    = 10006;
    case NOT_FOUND_ERROR     = 10007;
    case INTERNAL_ERROR      = 10008;
    case FATAL_ERROR         = 10009;

    public function description(): string
    {
        return match ($this) {
            self::E_ERROR             => 'Fatal Error',
            self::E_WARNING           => 'Warning',
            self::E_PARSE             => 'Parse Error',
            self::E_NOTICE            => 'Notice',
            self::E_CORE_ERROR        => 'Core Error',
            self::E_CORE_WARNING      => 'Core Warning',
            self::E_COMPILE_ERROR     => 'Compile Error',
            self::E_COMPILE_WARNING   => 'Compile Warning',
            self::E_USER_ERROR        => 'User Error',
            self::E_USER_WARNING      => 'User Warning',
            self::E_USER_NOTICE       => 'User Notice',
            self::E_STRICT            => 'Strict Standards',
            self::E_RECOVERABLE_ERROR => 'Recoverable Error',
            self::E_DEPRECATED        => 'Deprecated',
            self::E_USER_DEPRECATED   => 'User Deprecated',
            self::GENERIC_ERROR       => 'General Error',
            self::UNKNOWN_DATABASE    => 'Unknown database',
            self::DATABASE_ERROR      => 'Database Error',
            self::VALIDATION_ERROR    => 'Validation Error',
            self::NOT_FOUND_ERROR     => 'Not Found',
            self::INTERNAL_ERROR      => 'Internal Error',
            self::FATAL_ERROR         => 'Fatal Error',
            default                   => 'Unknown Error',
        };
    }

    public static function fromCodeOrDefault(int $code): self
    {
        return self::tryFrom($code) ?? self::GENERIC_ERROR;
    }

}