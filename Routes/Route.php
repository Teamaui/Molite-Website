<?php

namespace Routes;

class Route
{

    private static array $routes;

    public static function add(string $method, string $path, string $controller, string $function): void
    {
        self::$routes[] = [
            "method" => $method,
            "path" => $path,
            "controller" => $controller,
            "function" => $function,
        ];
    }

    public static function run(): void
    {
        session_start();

        $path = isset($_SERVER["PATH_INFO"]) ? $_SERVER["PATH_INFO"] : "/";
        $method = $_SERVER["REQUEST_METHOD"];

        $pattern = "#^" . $path . "$#";

        foreach (self::$routes as $route) {
            if (preg_match($pattern, $route["path"], $variables) && $method == $route["method"]) {
                $controller = new $route["controller"];
                $function = $route["function"];

                array_shift($variables);

                call_user_func_array([$controller, $function], $variables);
                return;
            }
        }

        http_response_code(404);
        echo "CONTROLLER TIDAK DITEMUKAN";
        return;
    }
}
