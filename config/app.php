<?php

return [
    "name"   => env("SCOOB_NAME") ?? "Not Named",
    "domain" => env("SCOOB_DOMAIN") ?? "localhost",
    "token"  => env("SCOOB_TOKEN") ?? null,
];