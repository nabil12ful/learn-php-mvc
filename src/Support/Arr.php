<?php
namespace Nopel\Support;

use ArrayAccess;

class Arr 
{
    /**
     * Get a subset of the items from the given array.
     *
     * @param  array  $array
     * @param  array|string  $keys
     * @return array
     */
    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * Get all of the given array except for a specified array of keys.
     *
     * @param  array  $array
     * @param  array|string|int|float  $keys
     * @return array
     */
    public static function except($array, $keys)
    {
        return static::forget($array, $keys);
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  iterable  $array
     * @param  int  $depth
     * @return array
     */
    public static function flatten($array, $depth = INF)
    {
        $result = [];
        foreach($array as $item)
        {
            if(!is_array($item))
            {
                $result[] = $item;
            }elseif($depth === 1)
            {
                $result = array_merge($result, array_values($item));
            }else{
                $result = array_merge($result, Static::flatten($item, $depth - 1));
            }
        }
        return $result;
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($array, $key, $default = null)
    {
        if(!static::accessible($array))
        {
            return value($default);
        }

        if(is_null($key)){
            return $array;
        }

        if(static::exists($array,$key))
        {
            return $array[$key];
        }

        if(!str_contains($key, '.'))
        {
            return $array[$key] ?? value($default);
        }

        foreach(explode('.', $key) as $segment)
        {
            if(Static::accessible($array, $key) && Static::exists($array, $segment))
            {
                $array = $array[$segment];
            }else{
                return value($default);
            }
        }

        return $array;

    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param  array  $array
     * @param  string|int|null  $key
     * @param  mixed  $value
     * @return array
     */
    public static function set(&$array, $key, $value)
    {
        if(is_null($key))
        {
            return array_push($array, $value);
        }

        $keys = explode('.', $key);

        while(count($keys) > 1)
        {
            $key = array_shift($keys);
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
        return $array;
    }

    /**
     * Remove one array item from a given array using "dot" notation.
     *
     * @param  array  $array
     * @param  string|int  $keys
     * @return void
     */
    public static function unset(&$array, $key)
    {
        static::set($array, $key, null);
    }

    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param  array  $array
     * @param  array|string|int|float  $keys
     * @return void
     */
    public static function forget(&$array, $keys)
    {
        $orginal = &$array;
        $keys = (array) $keys;
        if(!count($keys))
        {
            return;
        }

        foreach($keys as $key)
        {
            // var_dump($key);
            if(static::exists($array, $key))
            {
                unset($array[$key]);
                continue;
            }
            $parts = explode('.', $key);
            $array = &$orginal;
            while(count($parts) > 1)
            {
                $part = array_shift($parts);
                if(isset($array[$part]) && is_array($array[$part]))
                {
                    $array = &$array[$part];
                }else{
                    continue;
                }
            }
            unset($array[array_shift($parts)]);
        }
    }

    /**
     * Determine whether the given value is array accessible.
     *
     * @param  mixed  $value
     * @return bool
     */
    public static function accessible($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|int  $key
     * @return bool
     */
    public static function exists($array, $key)
    {
        if($array instanceof ArrayAccess)
        {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * Check if an item or items exist in an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|array  $keys
     * @return bool
     */
    public static function has($array, $keys)
    {
        if(is_null($keys))
        {
            return false;
        }

        $keys = (array) $keys;

        if($keys === [])
        {
            return false;
        }

        foreach($keys as $key)
        {
            $subArray = $array;
            if(static::exists($array, $key))
            {
                continue;
            }
            foreach(explode('.', $key) as $segment)
            {
                if(static::accessible($subArray) && static::exists($subArray, $segment))
                {
                    $subArray = $subArray[$segment];
                }else{
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Return the last element in an array passing a given truth test.
     *
     * @param  array  $array
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public static function last($array, callable $callback = null, $default = null)
    {
        if(is_null($callback))
        {
            return empty($array) ? value($default) : end($array);
        }
        return static::first(array_reverse($array, true), $callback, $default);
    }

    /**
     * Return the first element in an array passing a given truth test.
     *
     * @param  iterable  $array
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public static function first($array, callable $callback = null, $default = null)
    {
        if(is_null($callback))
        {
            if(empty($array))
            {
                return value($default);
            }
            foreach($array as $item)
            {
                return $item;
            }
        }

        foreach($array as $key => $value)
        {
            if(call_user_func($callback, $value, $key))
            {
                return $value;
            }
        }

        return value($default);
    }
}