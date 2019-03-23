<?php

namespace App\Client;

use Illuminate\Support\Str;

class Token
{
    /**
     * @return string
     */
    public static function generateToken()
    {
        return Str::random(60);
    }
}
