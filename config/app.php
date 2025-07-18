<?php

use ScoobEcoCore\Boot\Session;

return [
    "name"      => env("SCOOB_NAME", "Not Named"),
    "domain"    => env("SCOOB_DOMAIN", "localhost"),
    "token"     => env("SCOOB_TOKEN", Session::get("token")),
    "life_time" => env("SCOOB_LIFETIME", 60),
];