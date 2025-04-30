<?php

use JetBrains\PhpStorm\NoReturn;
use ScoobEcoCore\Enum\ErrorType;
use ScoobEcoCore\Support\Config;

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $default;

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

if (!function_exists('isJsonRequest')) {
    function isJsonRequest(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}

if (!function_exists('scoob_input_token')) {
    function scoob_input_token(): string
    {
        $token = Config::get("app.token");
        return "<input type='hidden' name='_token' value='{$token}' />";
    }
}

if (!function_exists('scoob_token')) {
    function scoob_token(): string
    {
        $token = Config::get("app.token");
        return $token;
    }
}

if (!function_exists('route')) {
    function route(
        string $name,
        ?array $parameters = []
    ): string
    {
        $route = \ScoobEcoCore\Support\RouteConverter::run($name);
        $uri   = $route["uri"];

        if (count($parameters) > 0) {
            foreach ($parameters as $key => $value) {
                $uri = preg_replace("/\{.*?\}/", $value, $uri, 1);
            }
        }

        return $uri;
    }
}

