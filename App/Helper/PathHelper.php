<?php

class PathHelper
{
    public static function getPath(): String
    {
        $path = $_SERVER["SCRIPT_NAME"];

        return $path; 
    }
}
