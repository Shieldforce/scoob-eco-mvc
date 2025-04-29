<?php

namespace ScoobEcoCore\Support;

class Env {

    public static function load(string $path = __DIR__ . '/../../.env') {

        if (!file_exists($path)) return;

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if(str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $_ENV[trim($key)] = trim(str_replace(['"', '\''], ["",""], $value));
            }
        }

    }
}