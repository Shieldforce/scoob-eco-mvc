<?php

use ScoobEco\Http\Middlewares\ClearFormMiddleware;

return [
    "/"          => [
        "action"      => "ScoobEco\Http\Controllers\Site\HomeController@index",
        "name"        => "pages.site.index",
        "method"      => "get",
        "middlewares" => [],
    ],
    "/login"     => [
        "action"      => "ScoobEco\Http\Controllers\Site\HomeController@login",
        "name"        => "pages.site.login",
        "method"      => "get",
        "middlewares" => [],
    ],
    "/login/run" => [
        "action"      => "ScoobEco\Http\Controllers\Site\HomeController@loginRun",
        "name"        => "pages.site.loginRun",
        "method"      => "post",
        "middlewares" => [
            new ClearFormMiddleware,
        ],
    ],
];