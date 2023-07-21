<?php

namespace App\Service\V1\Auth;

use http\Exception\InvalidArgumentException;

class GenerateKeyService{

    public static function generate($length = 10, $type = 'mixed', $case = 'mixed')
    {
        $characters = '';

        if ($type === 'mixed') {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        } elseif ($type === 'alpha') {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } elseif ($type === 'number') {
            $characters = '0123456789';
        }

        // If $length is not specified or set to null, use the default value of 10.
        $length = $length ?? 10;

        // If $case is not specified or set to null, use the default value of 'mixed'.
        $case = $case ?? 'mixed';

        if ($case === 'mixed') {
            $characters .= 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        } elseif ($case === 'lower') {
            $characters .= 'abcdefghijklmnopqrstuvwxyz';
        } elseif ($case === 'upper') {
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        $string = '';
        $charactersLength = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, $charactersLength - 1)];
        }

        return $string;
    }
}
