<?php

namespace ScoobEcoCore\Http;

interface MiddlewareInterface
{
    public function handle(Request $request);
}