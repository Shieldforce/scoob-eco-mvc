<?php

namespace ScoobEcoCore\Http;

use Exception;
use ReflectionNamedType;

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

        $seg = $this->extractSegmentsUrl(
            $route["path"],
            $requestUri,
            '/\/?{(.*?)\??}/'
        );

        if (!$seg["ok"]) {
            return ["ok" => false];
        }

        return [
            "ok"     => true,
            "params" => $seg["params"] ?? [],
        ];
    }

    protected function extractSegmentsUrl(string $path, string $uri, string $pattern)
    {
        $segments           = array_values(array_filter(explode('/', $path)));
        $segmentsUri        = array_values(array_filter(explode('/', $uri)));
        $params             = [];
        $matchedSegments    = [];
        $matchedSegmentsUri = [];

        if (count($segmentsUri) > count($segments)) {
            return ["ok" => false];
        }

        foreach ($segments as $index => $segment) {
            if (preg_match($pattern, $segment, $match)) {
                $matchedSegments[]    = 1;
                $matchedSegmentsUri[] = 1;
                $params[$match[1]]    = $segmentsUri[$index] == "%7B1d2" ? null : $segmentsUri[$index];
                continue;
            }

            $matchedSegments[]    = $segment;
            $matchedSegmentsUri[] = $segmentsUri[$index];
        }

        return [
            "ok"     => $matchedSegments == $matchedSegmentsUri,
            "params" => $params
        ];
    }

    protected function verifyControllerExit(array $array, array $verify)
    {
        [
            $controller,
            $method
        ] = explode("@", $array["action"]);

        if (!class_exists($controller)) {
            throw new Exception("Controller not found: {$controller}", 404);
        }

        if (!method_exists($controller, $method)) {
            throw new Exception("Method not found: {$controller} -> {$method}", 404);
        }

        $instance = new $controller();

        $reflection   = new \ReflectionMethod($instance, $method);
        $paramsToPass = [];

        $paramsToPass = $this->mountParamsToPass(
            $reflection,
            $paramsToPass,
            $controller,
            $method,
            $verify
        );

        return $reflection->invokeArgs($instance, $paramsToPass);
    }

    protected function mountParamsToPass(
        $reflection,
        $paramsToPass,
        $controller,
        $method,
        $verify
    )
    {

        foreach ($reflection->getParameters() as $index => $param) {

            if (
                isset($verify["params"][$param->getName()]) ||
                in_array($param->getName(), array_keys($verify["params"]))
            ) {
                $paramsToPass[] = $verify["params"][$param->getName()] ?? null;
                continue;
            }

            if ($param->isDefaultValueAvailable()) {
                $paramsToPass[] = $param->getDefaultValue();
                continue;
            }

            $type = $param->getType();

            if (isset($type) && is_object($type) && !$type->isBuiltin()) {
                $className = $type->getName();
            }

            if (isset($className) && $className === Request::class) {
                $paramsToPass[] = $this->request;
                continue;
            }

            if (isset($className) && $className !== Request::class) {
                $paramsToPass[] = new $className();
                continue;
            }

            throw new Exception(
                "Cannot resolve parameter \${$param->getName()} in {$controller}::{$method}()"
            );
        }

        return $paramsToPass;
    }

    public static function getRoutes(): array
    {
        return (new Router(self::$someRequest))->routes;
    }

}