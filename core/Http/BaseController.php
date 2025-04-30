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

        $template = $this->tagPhp($template);

        $pattern  = '/@include\([\'"](.+?)[\'"]\)/';
        $template = $this->includes($template, $pattern);

        $tempPath = tempnam(sys_get_temp_dir(), 'tpl_') . '.blade.php';

        file_put_contents($tempPath, $template);

        ob_start();

        include $tempPath;

        return ob_get_clean();
    }

    public function includes(string $template, string $pattern)
    {
        do {
            $original = $template;

            $template = preg_replace_callback(
                $pattern,
                function ($matches) use ($pattern) {
                    $includePath = "/var/www/pages" . DIRECTORY_SEPARATOR .
                        str_replace(".", "/", $matches[1]) . ".blade.php";

                    if (!file_exists($includePath)) {
                        throw new Exception("Template file not found: {$includePath}");
                    }

                    $templateInclude = file_get_contents($includePath);

                    $templateInclude = $this->includes($templateInclude, $pattern);

                    $templateInclude = $this->tagPhp($templateInclude);

                    return $templateInclude;
                },
                $template
            );

        } while ($template !== $original);

        return $template;
    }

    public function tagPhp($template) {
        return preg_replace_callback(
            '/\{\{\s*(.*?)\s*\}\}/',
            fn($m) => "<?= " . trim($m[1]) . " ?>",
            $template
        );
    }

}