<?php

namespace ScoobEco\Http\Middlewares;

use ScoobEcoCore\Enum\ResponseType;
use ScoobEcoCore\Http\MiddlewareInterface;
use ScoobEcoCore\Http\Request;
use ScoobEcoCore\Http\Response;
use ScoobEcoCore\Support\Config;

class HttpMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        $domainEnv = Config::get('app.domain');
        header("Host: {$domainEnv}");

        if ($request->headers["host"] != $domainEnv) {
            $msg = "Host not accept! Verify .env -> SCOOB_DOMAIN, ust be ";
            $msg .= "equal to {$request->headers["host"]}";
            return Response::return(
                $request,
                ResponseType::error,
                $msg,
                403
            );
        }
    }
}