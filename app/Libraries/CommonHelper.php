<?php

namespace App\Libraries;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CommonHelper
{
    public static function customErrorResponse($errors)
    {
        $error_str = '';
        foreach ($errors as $error) {
            $error_str .= str_replace('.', ',', $error[0]);
        }
        return rtrim($error_str, ',');
    }
}
