<?php

namespace ScoobEcoCore\Exception;

use ScoobEcoCore\Enum\ErrorType;
use Throwable;

class ErrorHandler {

    public static function handle(
        Throwable $throwable,
        ErrorType $errorType = ErrorType::GENERIC_ERROR,
    ) {
        ddError($throwable, $errorType);
    }

}