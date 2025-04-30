<?php

namespace ScoobEcoCore\Enum;

enum ResponseType: int
{
    case error   = 1;
    case success = 0;

    public function message(): string
    {
        return match ($this) {
            self::error   => "Erro interno no servidor!",
            self::success => "Sucesso em realizar a operação!",
        };
    }
}