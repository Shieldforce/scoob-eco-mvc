<?php

namespace ScoobEcoCore\Http\Validation;

use ScoobEcoCore\Http\Request;

abstract class ValidationBaseService
{
    public function __construct(public Request $request, public array $rules) {}

    public function required()
    {
        return __FUNCTION__;
    }

    public function string()
    {
        return __FUNCTION__;
    }

    public function min()
    {
        return __FUNCTION__;
    }

    public function max()
    {
        return __FUNCTION__;
    }
}