<?php


namespace App\Utils;


use Illuminate\Support\Str;

class UtilFunctions
{
    public static function getRandomString(){
        $var = Str::random(64);
        return $var;
    }
}