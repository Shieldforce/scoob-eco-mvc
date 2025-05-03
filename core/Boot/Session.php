<?php

namespace ScoobEcoCore\Boot;

use ScoobEcoCore\Support\Config;
use ScoobEcoCore\Support\SimpleCrypt;

class Session
{
    public static function start()
    {
        $rand      = rand(9999999, 99999999);
        $cryptRand = SimpleCrypt::encrypt((string)$rand);

        if (!self::get("scoob_session")) {
            self::set("scoob_session", $cryptRand);
        }

        self::end();
    }

    public static function key()
    {
        return Config::get("session.key");
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key];
    }

    public static function destroy(string $key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function end()
    {
        // Session::destroy("scoob_session");
    }
}