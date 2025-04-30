<?php

namespace ScoobEco\Http\Middlewares;

use ScoobEcoCore\Enum\ResponseType;
use ScoobEcoCore\Http\MiddlewareInterface;
use ScoobEcoCore\Http\Request;
use ScoobEcoCore\Http\Response;
use ScoobEcoCore\Support\Config;

class TokenVerifyMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        $methods = [
            "POST",
            "PUT",
        ];
        if (
            in_array($request->method, $methods) &&
            (
                !isset($request->params["_token"]) ||
                $request->params["_token"] != Config::get("app.token")
            )
        ) {
            return Response::return(
                $request,
                ResponseType::error,
                "Scoob Token not found variable _token!",
                509
            );
        }
    }
}