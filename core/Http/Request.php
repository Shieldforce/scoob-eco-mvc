<?php

namespace ScoobEcoCore\Http;

class Request
{
    public string $method;
    public string $uri;
    public array  $headers;
    public array  $params;
    public array  $currentRoute;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? "GET";
        $this->uri    = strtok($_SERVER['REQUEST_URI'], '?');
        $this->params = $_REQUEST;
        $this->setHeaders();
    }

    public function setHeaders(): void
    {
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header           = str_replace(
                    '_',
                    '-',
                    strtolower(substr($key, 5))
                );
                $headers[$header] = $value;
            }
        }

        $this->headers = $headers;
    }
}