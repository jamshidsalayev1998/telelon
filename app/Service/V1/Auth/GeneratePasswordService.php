<?php

namespace App\Service\V1\Auth;

class GeneratePasswordService
{
    public static function generateUserPassword()
    {
        return rand(100000 , 999999);
    }
}
