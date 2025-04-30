<?php

use JetBrains\PhpStorm\NoReturn;
use ScoobEcoCore\Enum\ErrorType;

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $value = $default ?? $_ENV[$key] ?? getenv($key);

        if ($value === false || $value === null) {
            return $default;
        }

        $lowerValue = strtolower($value);
        $return     = match ($lowerValue) {
            'true'  => true,
            'false' => false,
            'null'  => null,
            default => is_numeric($value)
                ? (float)$value == (int)$value
                    ? (int)$value
                    : (float)$value
                : $value,
        };

        $_ENV[$key] = $return;
        return $return;
    }
}

if (!function_exists('dd')) {
    function dd(
        mixed $keys
    ): void
    {
        http_response_code(500);
        echo '<pre style="background: black; color: white;padding:20px;height: auto;">';
        print_r($keys);
        echo '</pre>';
        die();
    }
}

if (!function_exists('ddError')) {
    function ddError(
        ?Throwable $throwable = null,
        ?ErrorType $errorType = null,
    )
    {
        if (isset($errorType) && isset($throwable)) {
            styleError($throwable, $errorType);
        }
    }
}

if (!function_exists('styleError')) {
    #[NoReturn]
    function styleError(
        ?Throwable $throwable = null,
        ?ErrorType $errorType = null,
    ): void
    {
        require __DIR__ . "/../Exception/PageError/index.blade.php";
    }
}

if (!function_exists('view')) {
    function view(string $routeName, array $data = []): string
    {
        return \ScoobEcoCore\Http\BaseController::view($routeName, $data);
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return '/' . ltrim($path, '/');
    }
}

