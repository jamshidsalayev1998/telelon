<?php

namespace App\Service\V1\Auth;

use App\Models\UserCode;

class SendPasswordToUserService
{
    public static function sendPasswordToUser($password , $number, $userId)
    {
        UserCode::create([
            'code' => $password,
            'user_id' => $userId
        ]);

    }
}
