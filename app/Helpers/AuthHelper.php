<?php

namespace App\Helpers;

class AuthHelper
{
    public static function userAuth()
    {
        return auth()->user();
    }
}
