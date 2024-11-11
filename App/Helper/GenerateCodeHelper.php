<?php

namespace App\Helper;

class generateCodeHelper
{
    public static function generateToken($length = 32)
    {
        return bin2hex(random_bytes($length / 2));
    }
}
