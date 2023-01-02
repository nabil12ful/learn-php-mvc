<?php
namespace Nopel\Support;

class Hash
{
    public static function password($value)
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    public static function make($value)
    {
        return Static::password($value);
    }

    public static function makeToken($value){
        return sha1($value . time());
    }

    public static function verify($value, $hashedValue)
    {
        return password_verify($value, $hashedValue);
    }
}