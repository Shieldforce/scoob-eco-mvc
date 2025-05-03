<?php

namespace ScoobEcoCore\Http;

use ReflectionClass;
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
        $middlewaresFiles = glob(__DIR__ . "/BootMiddlewares/*.php");
        foreach ($middlewaresFiles as $middlewareFile) {
            $xPath          = explode("/", $middlewareFile);
            $httpPath       = $xPath[count($xPath) - 3];
            $middlewarePath = $xPath[count($xPath) - 2];
            $filePath       = $xPath[count($xPath) - 1];
            $join           = implode("\\", [
                $httpPath,
                $middlewarePath,
                $filePath,
            ]);

            $join      = str_replace([".php"], [""], $join);
            $className = "ScoobEcoCore\\{$join}";

            if (class_exists($className)) {
                $middleware = new $className();
                self::addMiddlewares($middleware);
                $middleware->handle($this->request);
            }
        }
    }

    public static function getMiddlewares(): array
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
            $class = new $middleware();
            self::addMiddlewares($class);
            $class->handle($this->request);
        }
    }

    public function executeRouteMiddlewares($routesMiddlewares): void
    {
        foreach ($routesMiddlewares as $routeMiddleware) {
            $class = new $routeMiddleware();
            self::addMiddlewares($class);
            $class->handle($this->request);
        }
    }
}