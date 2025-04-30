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
    )
    {
        $data["_original_dir"] = str_replace(["core/Http"], [""], __DIR__);

        extract($data);

        $template = file_get_contents($pathFile);

        $template = preg_replace_callback('/\{\{\s*(.*?)\s*\}\}/', function ($matches) {
            $expression = trim($matches[1]);
            return "<?= $expression ?>";
        }, $template);

        $template = preg_replace_callback(
            '/@include\([\'"](.+?)[\'"]\)/',
            function ($matches) use ($pathFile) {
                $includePath     = "/var/www/pages" .
                    DIRECTORY_SEPARATOR .
                    str_replace(".", "/", $matches[1]) . ".blade.php";
                $templateInclude = file_get_contents($includePath);
                $templateInclude = preg_replace_callback('/\{\{\s*(.*?)\s*\}\}/', function ($matches) {
                    $expression = trim($matches[1]);
                    return "<?= $expression ?>";
                }, $templateInclude);
                return $templateInclude;
            }, $template);

        $tempPath = tempnam(sys_get_temp_dir(), 'tpl_') . '.blade.php';

        file_put_contents($tempPath, $template);

        ob_start();

        include $tempPath;

        return ob_get_clean();
    }

}