<?php

use ScoobEco\Http\Middlewares\ClearFormMiddleware;

return [
    "/"                   => [
        "action"      => "ScoobEco\Http\Controllers\Site\HomeController@index",
        "name"        => "pages.site.index",
        "method"      => "get",
        "middlewares" => [],
    ],
    "/user/save" => [
        "action"      => "ScoobEco\Http\Controllers\Site\HomeController@userSave",
        "name"        => "pages.site.userSave",
        "method"      => "post",
        "middlewares" => [
            new ClearFormMiddleware,
        ],
    ],
];