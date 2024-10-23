<?php

class FlashMessageHelper
{
    public static function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function has($key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function get($key): String
    {
        if (isset($_SESSION[$key])) {
            $message = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $message;
        }
    }
}
