<?php

use ScoobEco\Http\Middlewares\ClearFormMiddleware;
use ScoobEco\Http\Middlewares\Validation\LoginValidationMiddleware;

return [
    "/login"     => [
        "action"      => "ScoobEco\Http\Controllers\Site\AuthController@login",
        "name"        => "pages.site.login",
        "method"      => "get",
        "middlewares" => [],
    ],
    "/login/run" => [
        "action"      => "ScoobEco\Http\Controllers\Site\AuthController@loginRun",
        "name"        => "pages.site.loginRun",
        "method"      => "post",
        "middlewares" => [
            ClearFormMiddleware::class,
            LoginValidationMiddleware::class,
        ],
    ],
];