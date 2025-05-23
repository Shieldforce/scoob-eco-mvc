<?php

namespace ScoobEcoCore\Boot;

use ScoobEcoCore\Enum\ErrorType;
use ScoobEcoCore\Exception\ErrorHandler;
use ScoobEcoCore\Http\BaseMiddleware;
use ScoobEcoCore\Http\Request;
use ScoobEcoCore\Http\Router;
use ScoobEcoCore\Support\Config;
use ScoobEcoCore\Support\Env;
use Throwable;

class Start
{

    public Request $request;
    public Router  $router;

    public function __construct()
    {
        try {
            session_start();
            $this->loadEnv();
            $this->loadConfig();
            $this->loadSession();
            $this->loadRequest();
            $this->loadBootMiddlewares();
            $this->loadRouter();

        } catch (Throwable $th) {
            ErrorHandler::handle(
                $th,
                ErrorType::fromCodeOrDefault($th->getCode()),
            );
        }

    }

    protected function loadEnv()
    {
        Env::load();
    }

    protected function loadConfig()
    {
        Config::load();
    }

    protected function loadRequest()
    {
        $this->request = new Request();
    }

    protected function loadRouter()
    {
        $this->router = new Router($this->request);
        $this->router->dispatch();
    }

    protected function loadBootMiddlewares()
    {
        $middleware = new BaseMiddleware($this->request);
        $middleware->executeMiddlewares();
    }

    protected function loadSession()
    {
        Session::start();
    }

}