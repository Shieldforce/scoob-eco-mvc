<?php

namespace ScoobEcoCore\Http;

use ScoobEco\Http\Middlewares\OrderExecuteMiddlewares;

class BaseMiddleware
{
    private static array $middlewares = [];

    public function __construct(public Request $request) {}

    public static function addMiddlewares(MiddlewareInterface $middleware): void
    {
        self::$middlewares[] = $middleware;
    }

    public function loadBootMiddlewares(): void
    {
        $middlewaresFiles = glob(__DIR__ . "/../../app/Http/Middlewares/*.php");
        foreach ($middlewaresFiles as $middlewareFile) {
            $xPath = explode("/", $middlewareFile);

            $appPath        = $xPath[count($xPath) - 4];
            $httpPath       = $xPath[count($xPath) - 3];
            $middlewarePath = $xPath[count($xPath) - 2];
            $filePath       = $xPath[count($xPath) - 1];
            $join           = implode("\\", [
                $appPath,
                $httpPath,
                $middlewarePath,
                $filePath,
            ]);

            $join      = str_replace([".php"], [""], $join);
            $className = "ScoobEco\\{$join}";

            if (class_exists($className)) {
                self::addMiddlewares(new $className($this->request));
            }
        }
    }

    public function getMiddlewares(): array
    {
        return self::$middlewares;
    }

    public function executeMiddlewares(): void
    {
        $this->loadBootMiddlewares();
        $this->loadOrderMiddlewares();
    }

    public function loadOrderMiddlewares(): void
    {
        $list = OrderExecuteMiddlewares::run();
        foreach ($list as $middleware) {
            $middleware->handle($this->request);
        }
    }

    public function executeRouteMiddlewares($routesMiddlewares): void
    {
        foreach ($routesMiddlewares as $routeMiddleware) {
            $routeMiddleware->handle($this->request);
        }
    }
}