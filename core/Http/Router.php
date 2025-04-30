<?php

namespace ScoobEcoCore\Http;

use Exception;
use Throwable;

class Router
{
    protected array  $routes = [];
    protected static $someRequest;

    public function __construct(public Request $request)
    {
        self::$someRequest = $request;
        $this->loadRoutes();
    }

    protected function loadRoutes(): void
    {
        $this->routes = [];

        $routeFiles = glob(__DIR__ . "/../../routes/*.php");

        foreach ($routeFiles as $routeFile) {

            $routes = require $routeFile;

            if (is_array($routes)) {
                $this->routes = array_merge($this->routes, $routes);
            }

        }
    }

    public function dispatch()
    {
        $requestUri = "/" . trim($this->request->uri, '/');

        foreach ($this->routes as $route => $array) {
            $route = [
                "path" => $route,
            ];

            $route = array_merge($route, $array);

            // Middleware ---
            if (isset($route["middlewares"]) && count($route["middlewares"]) > 0) {
                $baseMiddleware = new BaseMiddleware($this->request);
                $baseMiddleware->executeRouteMiddlewares($route["middlewares"]);
            }

            // Verificar segmentos
            $verify = $this->verifySegments($requestUri, $route);
            if ($verify["ok"]) {
                $this->request->currentRoute = $route;
                return $this->verifyControllerExit($array, $verify);
            }
        }
        throw new Exception("Route not found", 404);
    }

    protected function verifySegments($requestUri, $route)
    {
        if (strtoupper($this->request->method) != strtoupper($route['method'])) {
            return ["ok" => false];
        }

        $newRoutePath        = $route['path'];
        $params["variables"] = [];
        $params["match"]     = [];

        $patternParams = "/\/?{(.*?)\??}/";

        if (preg_match_all($patternParams, $newRoutePath, $matches)) {

            $newRoutePath        = preg_replace($patternParams, '(?:/(.*))?', $newRoutePath);
            $params["match"]     = array_merge($params["match"], $matches[1]);
            $params["variables"] = array_merge($params["variables"], $matches[0]);
        }

        $patternRoute = "/^" . str_replace("/", "\/", $newRoutePath) . "$/";

        if (preg_match($patternRoute, $requestUri, $matches)) {
            unset($matches[0]);

            $keys          = $params["match"];
            $matchesParams = explode("/", $matches[1]);
            $params        = $this->matchArrayCombine($matchesParams, $keys);

            return [
                "ok"     => true,
                "params" => $params,
            ];
        }

        return ["ok" => false];
    }

    protected function matchArrayCombine($matchesParams, $keys)
    {
        try {
            $match = (count($keys) > 0 && count($matchesParams) > 0) ?
                array_combine($keys, $matchesParams) :
                [];
            return $match;
        } catch (Throwable $e) {
            throw new Exception("Route not found!", 404);
        }
    }

    protected function verifyControllerExit(array $array, array $verify)
    {
        [
            $controller,
            $method,
        ] = explode("@", $array["action"]);

        if (!class_exists($controller)) {
            throw new Exception(
                "Controller not found: {$controller}",
                404
            );
        }

        if (!method_exists($controller, $method)) {
            throw new Exception(
                "Method not found: {$controller} -> {$method}",
                404
            );
        }

        return (new $controller)
            ->$method(
                $this->request,
                ...array_values($verify["params"]
                )
            );
    }

    public static function getRoutes(): array
    {
        return (new Router(self::$someRequest))->routes;
    }

}