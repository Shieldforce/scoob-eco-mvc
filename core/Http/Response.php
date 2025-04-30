<?php

namespace ScoobEcoCore\Http;

use Exception;
use ScoobEcoCore\Enum\ResponseType;

class Response
{
    public static function return(
        Request      $request,
        ResponseType $responseType,
        string       $message,
        int          $status,
    )
    {
        $response = [
            "error"   => $responseType->value,
            "message" => $message,
        ];

        http_response_code($status);

        if (isJsonRequest()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }

        if ($response["error"]) {
            throw new Exception(
                $message,
                $status
            );
        }

        return $response;
    }
}