<?php

namespace ScoobEcoCore\Http;

use Exception;

class BaseController
{

    public static function view(string $routeName, array $params = []): string
    {
        $routeReplace = str_replace(["."], ["/"], $routeName);
        $path         = str_replace(["core/Http"], [""], __DIR__);
        $file         = $path . $routeReplace . ".blade.php";

        if (!file_exists($file)) {
            throw new Exception("Page not found: " . $routeName);
        }

        echo (new BaseController)->render($file, $params);

        return "";
    }

    public function render(
        string $pathFile,
        array  $data = [],
    ) {
        extract($data);

        $template = file_get_contents($pathFile);

        $tempPath = tempnam(sys_get_temp_dir(), 'tpl_') . '.blade.php';

        file_put_contents($tempPath, $template);

        ob_start();

        include $tempPath;

        return ob_get_clean();
    }

}