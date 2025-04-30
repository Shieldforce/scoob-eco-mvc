<?php

namespace ScoobEcoCore\Support;

use ScoobEcoCore\Http\Router;

class RouteConverter
{
    public static function run(string $routeName): array
    {
        $routes  = Router::getRoutes();
        $returns = [];
        foreach ($routes ?? [] as $index => $route) {
            if ($routeName == $route["name"]) {
                $returns[$routeName] = [
                    "name"   => $route["name"],
                    "action" => $route["action"],
                    "uri"    => $index,
                ];
            }
        }
        return $returns[$routeName] ?? $returns;
    }
}