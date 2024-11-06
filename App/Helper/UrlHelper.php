<?php

class UrlHelper
{
    const BASE_URL = "http://localhost/Molita/";
    const BASE_URL2 = "http://localhost:8080/";

    public static function baseUrl($path = "", $type = "1")
    {
        if ($type == 1) {
            return rtrim(self::BASE_URL, "/") . "/" . ltrim($path, "/");
        } else {
            return rtrim(self::BASE_URL2, "/") . "/" . ltrim($path, "/");
        }
    }

    public static function css($file)
    {
        return self::baseUrl("Public/css/" . $file . ".css");
    }

    public static function js($file)
    {
        return self::baseUrl("Public/js/" . $file . ".js");
    }

    public static function img($file)
    {
        return self::baseUrl("Public/img/" . $file);
    }

    public static function route($path,)
    {
        return self::baseUrl("/Public/index.php/" . ltrim($path, "/"), "1");
    }

    public static function redirect($path)
    {
        header("Location: " . self::route($path));
        exit();
    }
}
