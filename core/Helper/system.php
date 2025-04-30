<?php

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