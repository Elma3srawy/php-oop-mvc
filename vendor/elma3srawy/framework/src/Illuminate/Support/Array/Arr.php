<?php 

namespace Illuminate\Support\Array;

class Arr
{
    public static function only(array $array , string|array $keys): array
    {
        $keys = array_flip((array) $keys);
        return array_intersect_key($array, $keys);
    }

    public static function get(array $array, string $key, $default = null)
    {
        if(!is_array($array)){
            return $default;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        foreach(explode('.' , $key) as $segment)
        {
            if(is_array($array) && array_key_exists($segment , $array))
            {
                $array = $array[$segment];
                
            }else{
                return $default;
            }
        }

        return $array;
    }

    public static function getMany(array $array, array $keys, $default = null)
    {
        $items = [] ;
        foreach($keys as $key => $default)
        {
            if(is_numeric($key)){
                [$key , $default] = [$default , null];
            }

            $items[$key] = self::get($array , $key , $default);
        }
        return  $items;
    }

    public static function set(array &$array, string $key, $value)
    {
        if ($key === null) {
            return $array = $value;
        }

        $keys = explode('.', $key);

        foreach ($keys as  $keySegment) {
            if (count($keys) === 1) {
                $array[$keySegment] = $value;
            } else {
                if (!isset($array[$keySegment]) || !is_array($array[$keySegment])) {
                    $array[$keySegment] = $value;
                }
                $array = &$array[$keySegment];
            }
        }
    }

    public static function has(array $array, string $key): bool
    {
        if (!$array || $key === null) {
            return false;
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return false;
            }

            $array = $array[$segment];
        }

        return true;
    }



    public static function except(array $array , array $keys)
    {
        if(!is_array($array)){
            return ;
        }
        foreach($keys as $key)
        {
            if(self::has($array , $key))
            {
                unset($array[$key]);
            }
        }
        return $array;
    }

    public static function first(array $array, callable $callback = null, $default = null)
    {
        foreach ($array as $value) {
            if ($callback === null || $callback($value)) {
                return $value;
            }
        }
        return $default;
    }

    public static function last(array $array, callable $callback = null, $default = null)
    {
        $result = $default;
        foreach ($array as $value) {
            if ($callback === null || $callback($value)) {
                $result = $value;
            }
        }
        return $result;
    }

}

