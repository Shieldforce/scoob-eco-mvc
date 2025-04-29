<?php

namespace ScoobEcoCore\Boot;

use ScoobEcoCore\Support\Config;
use ScoobEcoCore\Support\Env;
use Throwable;

class Start
{

    public function __construct()
    {
        try {
            $this->loadEnv();
            $this->loadConfig();

        } catch (Throwable $th) {
            var_dump($th);
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

}