<?php

class UrlHelper
{
    /**
     * Mendapatkan base URL secara dinamis.
     */
    private static function getBaseUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        $baseUrl = rtrim($protocol . "://" . $host . $scriptName, "/") . "/";
        return $baseUrl;
    }

    /**
     * Base URL utama untuk aplikasi.
     */
    public static function baseUrl($path = "")
    {
        return rtrim(self::getBaseUrl(), "/") . "/" . ltrim($path, "/");
    }

    /**
     * Generate URL untuk file CSS.
     */
    public static function css($file)
    {
        return self::baseUrl("css/" . $file . ".css");
    }

    /**
     * Generate URL untuk file JS.
     */
    public static function js($file)
    {
        return self::baseUrl("js/" . $file . ".js");
    }

    /**
     * Generate URL untuk file gambar.
     */
    public static function img($file)
    {
        return self::baseUrl("img/" . $file);
    }

    /**
     * Generate URL untuk route tertentu.
     */
    public static function route($path)
    {
        return self::baseUrl("index.php/" . ltrim($path, "/"));
    }

    /**
     * Redirect ke route tertentu.
     */
    public static function redirect($path)
    {
        header("Location: " . self::route($path));
        exit();
    }
}
