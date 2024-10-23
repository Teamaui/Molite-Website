<?php

namespace App\Helper;

class ViewReader
{
    public static function view(string $path, array $data = [])
    {
        extract($data);

        $pathNow = __DIR__ . "/../View/" . $path . ".php";
        if (file_exists($pathNow)) {
            require_once $pathNow;
        }
    }
}
