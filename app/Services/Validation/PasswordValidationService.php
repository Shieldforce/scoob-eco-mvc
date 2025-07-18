<?php

namespace ScoobEco\Services\Validation;

use ScoobEcoCore\Http\Validation\ValidationBaseService;

class PasswordValidationService extends ValidationBaseService
{
    public function password() {
        $rules = [];

        foreach ($this->rules[__FUNCTION__] as $rule) {
            $rule = explode(":", $rule);
            if (!method_exists($this, $rule[0])) {
                continue;
            }

            $rules[$rule[0]] = $this->{$rule[0]}();
        }

        return $rules;
    }

    public function isPassword()
    {
        return ["validation" => false, "message" => "Campo obrigatório!"];
    }
}