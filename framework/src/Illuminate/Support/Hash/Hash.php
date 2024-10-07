<?php 

namespace Illuminate\Support\Hash;


class Hash
{
    /**
     * Summary of check
     * @param string $value
     * @param string $hash
     * @return bool
     */
    public static function check(string $value , string $hash):bool
    {
        return password_verify($value , $hash);
    }
    /**
     * Summary of make
     * @param mixed $value
     * @return string
     */
    public static function make($value)
    {
        return sha1($value);
    }
    /**
     * Summary of password
     * @param mixed $value
     * @return string
     */
    public static function password($value)
    { 
        return  password_hash($value , PASSWORD_BCRYPT);
    }
    

}