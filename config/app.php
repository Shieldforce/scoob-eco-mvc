<?php

use ScoobEcoCore\Boot\Session;

return [
    "name"   => env("SCOOB_NAME", "Not Named"),
    "domain" => env("SCOOB_DOMAIN", "localhost"),
    "token"  => Session::get("scoob_token"),
];