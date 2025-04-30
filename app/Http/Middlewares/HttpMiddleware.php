<?php

namespace ScoobEco\Http\Middlewares;

use ScoobEcoCore\Http\MiddlewareInterface;
use ScoobEcoCore\Http\Request;

class HttpMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        // intercept http ---
    }
}