<?php

namespace ScoobEco\Http\Middlewares;

class OrderExecuteMiddlewares
{
    public static function run(): array
    {
        return [
            new HttpMiddleware(),
            new TokenVerifyMiddleware(),
        ];
    }
}