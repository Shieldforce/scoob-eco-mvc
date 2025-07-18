<?php

namespace ScoobEcoCore\Boot;

use ScoobEcoCore\Support\Config;
use ScoobEcoCore\Support\SimpleCrypt;

class Session
{
    public static function start()
    {
        $cryptRand = SimpleCrypt::encrypt((string)self::key());

        if (self::diffTimeInMinutes() > Config::get("app.life_time")) {
            self::end();
        }

        if (!self::get("token")) {
            self::set([
                "token" => $cryptRand,
                "time"  => date("Y-m-d H:i:s"),
                "user"  => [
                    "id"    => "1",
                    "name"  => "Alexandre Ferreira",
                    "email" => "shieldforce2@gmail.com",
                ],
            ]);
        }
    }

    public static function diffTime()
    {
        $dateStartSession = date_create(self::get("time"));
        $dateNow          = date_create(date("Y-m-d H:i:s"));
        return date_diff($dateStartSession, $dateNow, true);
    }

    public static function diffTimeInMinutes()
    {
        return self::diffTime()->i ?? null;
    }

    public static function key()
    {
        return rand(9999999, 99999999);
    }

    public static function set(array $values)
    {
        $_SESSION["scoob_session"] = $values;
    }

    public static function get(?string $key = null)
    {
        return
            $_SESSION["scoob_session"][$key] ??
            $_SESSION["scoob_session"] ??
            null;
    }

    public static function destroy()
    {
        if (isset($_SESSION["scoob_session"])) {
            unset($_SESSION["scoob_session"]);
        }
    }

    public static function end()
    {
        Session::destroy();
    }
}