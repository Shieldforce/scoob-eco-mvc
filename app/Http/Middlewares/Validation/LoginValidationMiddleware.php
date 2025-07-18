<?php

namespace ScoobEco\Http\Middlewares\Validation;

use ScoobEco\Services\Validation\FieldsValidationService;
use ScoobEcoCore\Http\MiddlewareInterface;
use ScoobEcoCore\Http\Request;

class LoginValidationMiddleware implements MiddlewareInterface
{
    public function handle(Request $request)
    {
        $validation = new FieldsValidationService($request);

        $rules = $validation->rules([
            "email"    => [
                "required",
                "isEmail",
                "string"
            ],
            "password" => [
                "isPassword",
                "min:4",
                "max:20"
            ],
        ]);

        if(!$validation->getValidation()) {
            dd($rules);
        }
    }
}